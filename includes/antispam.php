<?php
// Lightweight, self-contained anti-spam for public forms on this site: a
// signed, time-windowed token (much harder to forge than the bare
// timestamp this form used before) plus simple file-based IP rate
// limiting. No third-party CAPTCHA, no external script to load, no
// consent-banner implications.
//
// The signing secret below only protects a spam-mitigation token, not
// real credentials or access, so it's fine to keep in the codebase
// directly rather than provisioning a separate secret file - this repo
// is private.
const ANTISPAM_SECRET = 'cf72c0e9373efc8d2ce2b0c61eb68a3f5a5cd8f3f51533d9afcd030cac72964a';

function antispam_token(): array
{
    $ts = time();
    $sig = hash_hmac('sha256', (string) $ts, ANTISPAM_SECRET);
    return ['ts' => $ts, 'sig' => $sig];
}

function antispam_verify_token(?string $ts, ?string $sig, int $minSeconds = 3, int $maxSeconds = 3600): bool
{
    if (!$ts || !$sig || !ctype_digit($ts)) {
        return false;
    }
    $expected = hash_hmac('sha256', $ts, ANTISPAM_SECRET);
    if (!hash_equals($expected, $sig)) {
        return false;
    }
    $age = time() - (int) $ts;
    return $age >= $minSeconds && $age <= $maxSeconds;
}

// Small file-based rate limiter: max $limit submissions per IP within
// $windowSeconds. Not built for high traffic, just to blunt repeat spam
// from the same source hitting a low-volume contact form. Fails open (lets
// the submission through) on any filesystem problem, so a hosting hiccup
// never blocks a real enquiry.
function antispam_rate_limit_ok(string $ip, int $limit = 5, int $windowSeconds = 3600): bool
{
    if ($ip === '') {
        return true;
    }

    $dir = __DIR__ . '/../data';
    if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
        return true;
    }

    $file = $dir . '/contact-rate-limit.json';
    $fh = @fopen($file, 'c+');
    if (!$fh) {
        return true;
    }

    flock($fh, LOCK_EX);
    $raw = stream_get_contents($fh);
    $data = $raw ? json_decode($raw, true) : [];
    if (!is_array($data)) {
        $data = [];
    }

    $now = time();
    $key = hash('sha256', $ip);
    $entries = array_values(array_filter($data[$key] ?? [], fn($t) => $now - $t < $windowSeconds));
    $ok = count($entries) < $limit;
    if ($ok) {
        $entries[] = $now;
    }
    $data[$key] = $entries;

    // Keep the file from growing unbounded - drop IPs with nothing recent.
    if (count($data) > 500) {
        foreach ($data as $k => $times) {
            $times = array_values(array_filter($times, fn($t) => $now - $t < $windowSeconds));
            if (empty($times)) {
                unset($data[$k]);
            } else {
                $data[$k] = $times;
            }
        }
    }

    ftruncate($fh, 0);
    rewind($fh);
    fwrite($fh, json_encode($data));
    flock($fh, LOCK_UN);
    fclose($fh);

    return $ok;
}

<?php
// Contact form handler: honeypot + signed timestamp + IP rate limit, then
// emails the enquiry straight to Grace. No database, nothing stored beyond
// a small rate-limit counter (see includes/antispam.php).

require __DIR__ . '/includes/antispam.php';

function fail(string $reason): void {
    header('Location: /contact.php?error=' . urlencode($reason));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.php');
    exit;
}

// Honeypot: a real visitor never fills this in.
if (!empty($_POST['website'])) {
    fail('spam');
}

// Signed timestamp: rejects forged/replayed values a bot posts without
// ever loading the real page, and anything too fast or too stale.
if (!antispam_verify_token($_POST['ts'] ?? null, $_POST['sig'] ?? null)) {
    fail('spam');
}

if (!antispam_rate_limit_ok($_SERVER['REMOTE_ADDR'] ?? '')) {
    fail('rate-limited');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('invalid');
}

$to = 'enquiries@gracepariser.co.uk';
$subject = 'gracepariser.co.uk enquiry from ' . $name;
$body = "Name: $name\nEmail: $email\n\n$message\n";
$headers = 'From: no-reply@gracepariser.co.uk' . "\r\n" .
           'Reply-To: ' . $email . "\r\n";

$ok = mail($to, $subject, $body, $headers);

if (!$ok) {
    fail('send-failed');
}

header('Location: /contact.php?sent=1');
exit;

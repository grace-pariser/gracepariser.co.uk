<?php
// Pulls Grace's public LinkedIn activity via an RSS.app bridge feed (LinkedIn
// itself has no public API for this) and writes it to assets/data/linkedin-feed.json,
// which includes/linkedin-feed.php reads for the homepage "From LinkedIn" section.
//
// Run manually with `php scripts/update-linkedin-feed.php`, or via the
// "Update LinkedIn feed" scheduled routine, which also commits and pushes
// the result so the deploy pipeline picks it up.

$feedUrl = 'https://rss.app/feeds/pseTVcr1EGWScdFN.xml';
$outputPath = __DIR__ . '/../assets/data/linkedin-feed.json';
$maxPosts = 6;
$snippetLength = 240;

// This PHP build has no openssl/curl extension, so shell out to the
// system curl binary instead of using file_get_contents over https.
$cmd = 'curl -s --max-time 20 -A ' . escapeshellarg('Mozilla/5.0 (compatible; gracepariser.co.uk feed updater)') . ' ' . escapeshellarg($feedUrl);
$xmlString = shell_exec($cmd);

if ($xmlString === null || trim($xmlString) === '') {
    fwrite(STDERR, "Failed to fetch feed\n");
    exit(1);
}

libxml_use_internal_errors(true);
$xml = simplexml_load_string($xmlString);
if ($xml === false) {
    fwrite(STDERR, "Failed to parse feed XML\n");
    exit(1);
}

function linkedin_feed_snippet(string $html, int $maxLength): string
{
    $text = strip_tags($html);
    $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    $text = preg_replace('/\s+/', ' ', $text);
    $text = trim($text);
    if (strlen($text) <= $maxLength) {
        return $text;
    }
    $truncated = substr($text, 0, $maxLength);
    $lastSpace = strrpos($truncated, ' ');
    if ($lastSpace !== false) {
        $truncated = substr($truncated, 0, $lastSpace);
    }
    return rtrim($truncated, " \t\n\r,.") . '...';
}

$posts = [];
foreach ($xml->channel->item as $item) {
    $posts[] = [
        'url' => (string) $item->link,
        'text' => linkedin_feed_snippet((string) $item->description, $snippetLength),
        'date' => date('j M Y', strtotime((string) $item->pubDate)),
        'timestamp' => strtotime((string) $item->pubDate),
    ];
    if (count($posts) >= $maxPosts) {
        break;
    }
}

usort($posts, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
foreach ($posts as &$post) {
    unset($post['timestamp']);
}
unset($post);

$data = [
    'updated' => gmdate('c'),
    'posts' => $posts,
];

file_put_contents($outputPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
echo 'Wrote ' . count($posts) . " posts to $outputPath\n";

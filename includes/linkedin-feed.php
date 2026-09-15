<?php
// Reads LinkedIn post data kept up to date by Grace's Make.com scenario
// (Apify LinkedIn scraper -> GitHub commit to assets/data/linkedin-feed.json,
// daily at 11:00 Europe/London). That file is a top-level JSON array of
// raw Apify post objects; this translates each into the flat shape the
// rest of the site expects. Returns [] if the cache is missing,
// unreadable, or not in the expected shape, so the homepage degrades
// gracefully rather than erroring.
$path = __DIR__ . '/../assets/data/linkedin-feed.json';
if (!is_file($path)) {
    return [];
}
$raw = json_decode(file_get_contents($path), true);
if (!is_array($raw)) {
    return [];
}

function linkedin_feed_clean_text(string $text): string
{
    $text = preg_replace('/[ \t]+/', ' ', $text);
    $text = preg_replace('/ *\n *(\n *)+/', "\n\n", $text);
    $text = preg_replace('/ *\n */', "\n", $text);
    return trim($text);
}

$posts = [];
foreach ($raw as $item) {
    $url = $item['linkedinUrl'] ?? null;
    $content = $item['content'] ?? null;
    $postedAt = $item['postedAt']['date'] ?? null;
    if (!$url || !$content || !$postedAt) {
        continue;
    }
    $posts[] = [
        'url' => $url,
        'fullText' => linkedin_feed_clean_text($content),
        'authorName' => $item['author']['name'] ?? 'Grace Pariser',
        'authorImage' => $item['author']['avatar']['url'] ?? null,
        'date' => date('j M Y', strtotime($postedAt)),
        'image' => $item['postImages'][0]['url'] ?? $item['ogImage'] ?? null,
    ];
}
return $posts;

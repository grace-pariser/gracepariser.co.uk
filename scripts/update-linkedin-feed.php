<?php
// Pulls Grace's public LinkedIn post activity directly from her public
// profile page (linkedin.com has no API for this, and the RSS.app bridge
// we tried first requires a paid plan) and writes assets/data/linkedin-feed.json,
// which includes/linkedin-feed.php reads for the homepage "From LinkedIn"
// section.
//
// This works by reading structured data (schema.org JSON-LD) that LinkedIn
// embeds in the logged-out profile page for search engines, plus a
// best-effort scan of the surrounding HTML to pick up each post's image.
// Both are undocumented implementation details of LinkedIn's page, not a
// stable API, so this script can break without warning if LinkedIn changes
// its markup. On failure it exits non-zero and leaves the existing cached
// JSON untouched; the calling routine is responsible for flagging that to
// Grace rather than failing silently.
//
// Run manually with `php scripts/update-linkedin-feed.php`, or via the
// "Update LinkedIn feed" scheduled routine, which also commits and pushes
// the result so the deploy pipeline picks it up.

$profileUrl = 'https://www.linkedin.com/in/grace-pariser/';
$outputPath = __DIR__ . '/../assets/data/linkedin-feed.json';
$maxPosts = 6;
$noImageSnippetLength = 420;
$leadSnippetLength = 550;

// This PHP build has no openssl/curl extension, so shell out to the
// system curl binary instead of using file_get_contents over https.
$cmd = 'curl -sL --max-time 20 -A ' . escapeshellarg('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36') . ' ' . escapeshellarg($profileUrl);
$html = shell_exec($cmd);

if ($html === null || trim($html) === '') {
    fwrite(STDERR, "Failed to fetch LinkedIn profile page\n");
    exit(1);
}

if (!preg_match('#<script type="application/ld\+json">(.*?)</script>#s', $html, $ldJsonMatch)) {
    fwrite(STDERR, "Could not find the embedded LinkedIn structured data (ld+json) - LinkedIn may have changed their page layout\n");
    exit(1);
}

$structuredData = json_decode($ldJsonMatch[1], true);
$graph = $structuredData[0]['@graph'] ?? $structuredData['@graph'] ?? null;
if (!is_array($graph)) {
    fwrite(STDERR, "Structured data didn't have the expected shape (no @graph) - LinkedIn may have changed their page layout\n");
    exit(1);
}

$postNodes = array_values(array_filter($graph, fn($node) => ($node['@type'] ?? null) === 'DiscussionForumPosting'));
if (count($postNodes) === 0) {
    fwrite(STDERR, "Found structured data but no posts (DiscussionForumPosting) in it - LinkedIn may have changed their page layout\n");
    exit(1);
}

function linkedin_feed_clean(string $text): string
{
    $text = preg_replace('/[ \t]+/', ' ', $text);
    $text = preg_replace('/ *\n *(\n *)+/', "\n\n", $text);
    $text = preg_replace('/ *\n */', "\n", $text);
    return trim($text);
}

function linkedin_feed_snippet(string $text, int $maxLength): string
{
    if (strlen($text) <= $maxLength) {
        return $text;
    }
    $truncated = substr($text, 0, $maxLength);
    $lastBreak = max(strrpos($truncated, ' '), strrpos($truncated, "\n"));
    if ($lastBreak !== false && $lastBreak > 0) {
        $truncated = substr($truncated, 0, $lastBreak);
    }
    return rtrim($truncated, " \t\n\r,.") . '...';
}

// Best-effort: each post's permalink appears multiple times in the page
// (once near the structured data, again in a separate visual "posts"
// carousel further down that carries the image). Check a window after
// every occurrence of this specific post's own (unique) permalink.
function linkedin_feed_find_image(string $html, string $postUrl): ?string
{
    $offset = 0;
    while (($pos = strpos($html, $postUrl, $offset)) !== false) {
        $window = substr($html, $pos, 3000);
        if (preg_match('~https://media\.licdn\.com/[^"\'\s)]*feedshare[^"\'\s)]*~', $window, $imgMatch)) {
            return html_entity_decode($imgMatch[0], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        }
        $offset = $pos + strlen($postUrl);
    }
    return null;
}

// When a post has no native LinkedIn image, fall back to the Open Graph
// image of the first external link in the post text, if any (best-effort;
// failures here just mean no fallback image, not a script failure).
function linkedin_feed_first_external_url(string $text): ?string
{
    if (!preg_match('/https?:\/\/[^\s]+/', $text, $m)) {
        return null;
    }
    $url = rtrim($m[0], '.,;:!?)\'"');
    // Skip LinkedIn's own domains, including its lnkd.in shortener, which
    // serves an interstitial "you are leaving LinkedIn" page rather than
    // redirecting - its og:image is just LinkedIn's favicon, not useful.
    foreach (['linkedin.com', 'lnkd.in'] as $ownDomain) {
        if (stripos($url, $ownDomain) !== false) {
            return null;
        }
    }
    return $url;
}

function linkedin_feed_fetch_og_image(string $url): ?string
{
    $cmd = 'curl -sL --max-time 10 -A ' . escapeshellarg('Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0 Safari/537.36') . ' ' . escapeshellarg($url);
    $pageHtml = shell_exec($cmd);
    if (!$pageHtml) {
        return null;
    }
    if (preg_match('/<meta[^>]+property=["\']og:image["\'][^>]+content=["\']([^"\']+)["\']/i', $pageHtml, $m)
        || preg_match('/<meta[^>]+content=["\']([^"\']+)["\'][^>]+property=["\']og:image["\']/i', $pageHtml, $m)) {
        return html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    return null;
}

$authorImage = null;
if (preg_match('~https://media\.licdn\.com/dms/image/v2/[^"\'\s\\\\]*profile-displayphoto[^"\'\s\\\\]*~', $html, $avatarMatch)) {
    $authorImage = html_entity_decode($avatarMatch[0], ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

$posts = [];
foreach ($postNodes as $node) {
    $url = $node['url'] ?? $node['mainEntityOfPage'] ?? null;
    $text = $node['text'] ?? null;
    $datePublished = $node['datePublished'] ?? null;
    if (!$url || !$text || !$datePublished) {
        continue;
    }

    $cleanText = linkedin_feed_clean($text);
    $posts[] = [
        'url' => $url,
        'fullText' => $cleanText,
        'authorName' => $node['author']['name'] ?? 'Grace Pariser',
        'authorImage' => $authorImage,
        'date' => date('j M Y', strtotime($datePublished)),
        'image' => linkedin_feed_find_image($html, $url),
        'timestamp' => strtotime($datePublished),
    ];
}

if (count($posts) === 0) {
    fwrite(STDERR, "Parsed post nodes but none had the expected text/url/date fields - LinkedIn may have changed their page layout\n");
    exit(1);
}

usort($posts, fn($a, $b) => $b['timestamp'] <=> $a['timestamp']);
$posts = array_slice($posts, 0, $maxPosts);
foreach ($posts as $i => &$post) {
    unset($post['timestamp']);
    if (!$post['image']) {
        $externalUrl = linkedin_feed_first_external_url($post['fullText']);
        if ($externalUrl) {
            $post['image'] = linkedin_feed_fetch_og_image($externalUrl);
        }
    }
    // Only the lead card shows an image on the homepage (the grid cards
    // behind it are text-only there, though the modal still shows any
    // image on click), so every non-lead card has the same free space
    // and gets the longer, no-image-card snippet length.
    $length = $i === 0 ? $leadSnippetLength : $noImageSnippetLength;
    $post['text'] = linkedin_feed_snippet($post['fullText'], $length);
}
unset($post);

$data = [
    'updated' => gmdate('c'),
    'posts' => $posts,
];

file_put_contents($outputPath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "\n");
echo 'Wrote ' . count($posts) . " posts to $outputPath\n";

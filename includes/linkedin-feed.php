<?php
// Reads the cached LinkedIn post data kept up to date by
// scripts/update-linkedin-feed.php (run manually or by the "Update
// LinkedIn feed" routine). Returns [] if the cache is missing or
// unreadable so the homepage degrades gracefully.
$path = __DIR__ . '/../assets/data/linkedin-feed.json';
if (!is_file($path)) {
    return [];
}
$data = json_decode(file_get_contents($path), true);
return $data['posts'] ?? [];

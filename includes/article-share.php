<?php
// Share box for article pages. Expects $canonicalUrl and $pageTitle to
// already be in scope (both set by includes/header.php).
$shareTitle = trim(strtok($pageTitle, '|'));
$shareUrl = $canonicalUrl;
$twitterHref = 'https://twitter.com/intent/tweet?' . http_build_query(['text' => $shareTitle, 'url' => $shareUrl]);
$linkedinHref = 'https://www.linkedin.com/sharing/share-offsite/?' . http_build_query(['url' => $shareUrl]);
$emailHref = 'mailto:?' . http_build_query(['subject' => $shareTitle, 'body' => $shareUrl]);
?>
<div class="share-box">
    <p class="section-label">Share this</p>
    <div class="share-links">
        <a href="<?= htmlspecialchars($twitterHref) ?>" target="_blank" rel="noopener" class="share-link">Share on X</a>
        <a href="<?= htmlspecialchars($linkedinHref) ?>" target="_blank" rel="noopener" class="share-link">Share on LinkedIn</a>
        <a href="<?= htmlspecialchars($emailHref) ?>" class="share-link">Share by email</a>
        <button type="button" class="share-link" data-copy-url="<?= htmlspecialchars($shareUrl) ?>">Copy link</button>
    </div>
</div>

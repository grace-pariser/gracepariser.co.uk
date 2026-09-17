<?php
// "From LinkedIn" section: card grid + modal. Self-contained - just
// require this file where the section should appear. Set
// $linkedinFeedLead = false before requiring to render a plain grid
// of $linkedinFeedCount cards with no enlarged lead card.
$linkedinFeedLead = $linkedinFeedLead ?? true;
$linkedinFeedCount = $linkedinFeedCount ?? ($linkedinFeedLead ? 4 : 3);
$linkedinPosts = require __DIR__ . '/linkedin-feed.php';
$linkedinCards = array_slice($linkedinPosts, 0, $linkedinFeedCount);

// Trim each card's full text down for display: more room for the
// enlarged lead card, less for a plain grid card.
function linkedin_feed_card_text(array $post, int $maxLength = 420): string
{
    $text = $post['fullText'];
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

// Turn bare URLs in already-escaped text into real, clickable links.
function linkedin_feed_linkify(string $escapedText): string
{
    return preg_replace_callback(
        '/https?:\/\/[^\s<]+/i',
        function ($m) {
            $url = rtrim($m[0], '.,;:)!?');
            return '<a href="' . $url . '" target="_blank" rel="noopener">' . $url . '</a>';
        },
        $escapedText
    );
}
?>
<section class="section wrap">
    <p class="section-label">From LinkedIn</p>
    <div class="prose">
        <p>Shorter thoughts, posted more often, over on LinkedIn. This feed updates automatically, straight from my LinkedIn posts.</p>
    </div>
    <?php if ($linkedinCards): ?>
    <ul class="linkedin-feed">
        <?php foreach ($linkedinCards as $i => $post): ?>
        <?php $isLead = $i === 0 && $linkedinFeedLead; ?>
        <?php $cardText = $isLead ? $post['fullText'] : linkedin_feed_card_text($post, 420); ?>
        <?php $tag = $isLead ? 'div' : 'button'; ?>
        <li class="linkedin-card<?= $isLead ? ' linkedin-card-lead' : '' ?>">
            <<?= $tag ?><?= $isLead ? '' : ' type="button"' ?> class="linkedin-card-trigger"<?= $isLead ? '' : ' data-linkedin-index="' . $i . '"' ?>>
                <span class="linkedin-card-header">
                    <?php if ($post['authorImage']): ?>
                    <img src="<?= htmlspecialchars($post['authorImage']) ?>" alt="" class="linkedin-card-avatar" loading="lazy">
                    <?php endif; ?>
                    <span class="linkedin-card-author">
                        <span class="linkedin-card-author-name"><?= htmlspecialchars($post['authorName']) ?></span>
                        <span class="linkedin-feed-date"><?= htmlspecialchars($post['date']) ?></span>
                    </span>
                </span>
                <span class="linkedin-card-main">
                    <?php if ($isLead && $post['video']): ?>
                    <span class="linkedin-card-video-wrap">
                        <video src="<?= htmlspecialchars($post['video']['url']) ?>" <?php if ($post['video']['thumbnail']): ?>poster="<?= htmlspecialchars($post['video']['thumbnail']) ?>"<?php endif; ?> class="linkedin-card-image" controls playsinline></video>
                    </span>
                    <?php elseif ($isLead && $post['image']): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="" class="linkedin-card-image" loading="lazy">
                    <?php endif; ?>
                    <span class="linkedin-card-body">
                        <?php foreach (explode("\n\n", $cardText) as $para): ?>
                            <?php if (trim($para) === '') continue; ?>
                            <span class="linkedin-card-para"><?= nl2br(linkedin_feed_linkify(htmlspecialchars($para))) ?></span>
                        <?php endforeach; ?>
                        <?php if (!$isLead): ?>
                        <span class="linkedin-card-link"><?= $post['video'] ? 'Watch the video' : 'Read full post' ?> &rarr;</span>
                        <?php endif; ?>
                    </span>
                </span>
            </<?= $tag ?>>
        </li>
        <?php endforeach; ?>
    </ul>
    <script type="application/json" id="linkedin-feed-data"><?= json_encode(array_map(fn($p) => [
        'text' => $p['fullText'],
        'date' => $p['date'],
        'url' => $p['url'],
        'image' => $p['image'],
        'video' => $p['video'],
        'authorName' => $p['authorName'],
        'authorImage' => $p['authorImage'],
    ], $linkedinCards), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?></script>
    <div class="linkedin-modal" id="linkedin-modal" hidden>
        <div class="linkedin-modal-backdrop" data-linkedin-close></div>
        <div class="linkedin-modal-panel" role="dialog" aria-modal="true" aria-label="Full LinkedIn post">
            <button type="button" class="linkedin-modal-close" data-linkedin-close aria-label="Close">&times;</button>
            <div class="linkedin-card-header linkedin-modal-header">
                <img class="linkedin-card-avatar linkedin-modal-avatar" alt="" hidden>
                <span class="linkedin-card-author">
                    <span class="linkedin-card-author-name linkedin-modal-author"></span>
                    <span class="linkedin-feed-date linkedin-modal-date"></span>
                </span>
            </div>
            <div class="prose linkedin-modal-text"></div>
            <video class="linkedin-modal-video" controls playsinline hidden></video>
            <img class="linkedin-modal-image" alt="" hidden>
            <div class="cta-row">
                <a class="btn-quiet linkedin-modal-link" href="https://www.linkedin.com/in/grace-pariser/" target="_blank" rel="noopener">Read on LinkedIn</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="cta-row">
        <a class="btn-quiet" href="https://www.linkedin.com/in/grace-pariser/" target="_blank" rel="noopener">Follow on LinkedIn</a>
    </div>
</section>

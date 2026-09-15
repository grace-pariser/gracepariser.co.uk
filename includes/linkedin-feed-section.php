<?php
// "From LinkedIn" section: card grid + modal. Self-contained - just
// require this file where the section should appear. Set
// $linkedinFeedLead = false before requiring to render a plain grid
// of $linkedinFeedCount cards with no enlarged lead card.
$linkedinFeedLead = $linkedinFeedLead ?? true;
$linkedinFeedCount = $linkedinFeedCount ?? ($linkedinFeedLead ? 4 : 3);
$linkedinPosts = require __DIR__ . '/linkedin-feed.php';
$linkedinCards = array_slice($linkedinPosts, 0, $linkedinFeedCount);
?>
<section class="section wrap">
    <p class="section-label">From LinkedIn</p>
    <div class="prose">
        <p>Shorter thoughts, posted more often, over on LinkedIn.</p>
    </div>
    <?php if ($linkedinCards): ?>
    <ul class="linkedin-feed">
        <?php foreach ($linkedinCards as $i => $post): ?>
        <li class="linkedin-card<?= ($i === 0 && $linkedinFeedLead) ? ' linkedin-card-lead' : '' ?>">
            <button type="button" class="linkedin-card-trigger" data-linkedin-index="<?= $i ?>">
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
                    <?php if ($i === 0 && $linkedinFeedLead && $post['image']): ?>
                    <img src="<?= htmlspecialchars($post['image']) ?>" alt="" class="linkedin-card-image" loading="lazy">
                    <?php endif; ?>
                    <span class="linkedin-card-body">
                        <?php foreach (explode("\n\n", $post['text']) as $para): ?>
                            <?php if (trim($para) === '') continue; ?>
                            <span class="linkedin-card-para"><?= nl2br(htmlspecialchars($para)) ?></span>
                        <?php endforeach; ?>
                        <span class="linkedin-card-link">Read full post &rarr;</span>
                    </span>
                </span>
            </button>
        </li>
        <?php endforeach; ?>
    </ul>
    <script type="application/json" id="linkedin-feed-data"><?= json_encode(array_map(fn($p) => [
        'text' => $p['fullText'] ?? $p['text'],
        'date' => $p['date'],
        'url' => $p['url'],
        'image' => $p['image'],
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
            <img class="linkedin-modal-image" alt="" hidden>
            <div class="cta-row">
                <a class="btn-quiet linkedin-modal-link" target="_blank" rel="noopener">Read on LinkedIn</a>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="cta-row">
        <a class="btn-quiet" href="https://www.linkedin.com/in/grace-pariser/" target="_blank" rel="noopener">Follow on LinkedIn</a>
    </div>
</section>

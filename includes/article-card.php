<?php
function render_article_card(array $a): void {
    $title = htmlspecialchars($a['title']);
    $dek = htmlspecialchars($a['dek']);
    $meta = array_filter([$a['outlet'] ?? null, $a['date'] ?? null]);
    $metaStr = htmlspecialchars(implode(' · ', $meta));
    $hasHref = !empty($a['href']);
    $attrs = $hasHref && str_starts_with($a['href'], 'http') ? ' target="_blank" rel="noopener"' : '';
    ?>
    <div class="article-card">
        <?php if ($metaStr): ?><p class="article-meta"><?= $metaStr ?></p><?php endif; ?>
        <h3><?php if ($hasHref): ?><a href="<?= htmlspecialchars($a['href']) ?>"<?= $attrs ?>><?= $title ?></a><?php else: ?><?= $title ?><?php endif; ?></h3>
        <p><?= $dek ?></p>
        <?php if ($hasHref): ?><a class="article-card-link" href="<?= htmlspecialchars($a['href']) ?>"<?= $attrs ?>>Read more &rarr;</a><?php endif; ?>
    </div>
    <?php
}

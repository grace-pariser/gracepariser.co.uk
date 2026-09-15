<?php
function render_article_card(array $a): void {
    $title = htmlspecialchars($a['title']);
    $dek = htmlspecialchars($a['dek']);
    $meta = array_filter([$a['outlet'] ?? null, $a['date'] ?? null]);
    $metaStr = htmlspecialchars(implode(' · ', $meta));
    ?>
    <div class="article-card">
        <h3><?php if (!empty($a['href'])):
            $isExternal = str_starts_with($a['href'], 'http');
            $attrs = $isExternal ? ' target="_blank" rel="noopener"' : '';
        ?><a href="<?= htmlspecialchars($a['href']) ?>"<?= $attrs ?>><?= $title ?></a><?php else: ?><?= $title ?><?php endif; ?></h3>
        <p><?= $dek ?></p>
        <?php if ($metaStr): ?><p class="article-meta"><?= $metaStr ?></p><?php endif; ?>
    </div>
    <?php
}

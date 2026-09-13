<?php
function render_article_card(array $a, ?int $number = null): void {
    $title = htmlspecialchars($a['title']);
    $dek = htmlspecialchars($a['dek']);
    $meta = array_filter([$a['outlet'] ?? null, $a['date'] ?? null]);
    $metaStr = htmlspecialchars(implode(' · ', $meta));
    ?>
    <div class="article-card">
        <?php if ($number !== null): ?><span class="index-mark">No. <?= str_pad((string)$number, 2, '0', STR_PAD_LEFT) ?></span><?php endif; ?>
        <h3><?php if (!empty($a['href'])): ?><a href="<?= htmlspecialchars($a['href']) ?>"><?= $title ?></a><?php else: ?><?= $title ?><?php endif; ?></h3>
        <p><?= $dek ?></p>
        <?php if ($metaStr): ?><p class="article-meta"><?= $metaStr ?></p><?php endif; ?>
    </div>
    <?php
}

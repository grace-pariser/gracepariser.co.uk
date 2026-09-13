<?php
// Standalone link-in-bio page. Not in the main nav on purpose - this is
// meant to be shared directly (Instagram/LinkedIn bio, etc).
$pageTitle = 'Grace Pariser — Links';
$pageDescription = 'All my pages, products and profiles in one place.';
require __DIR__ . '/includes/header.php';

$groups = [
    'Products & services' => [
        ['label' => 'HR On Call — employment law & HR consultancy', 'href' => 'https://on-call.co.uk'],
        ['label' => 'The HR Vault — for HR consultants', 'href' => 'https://thehrvault.co.uk'],
        ['label' => 'Practice Hub — practice management for HR consultants', 'href' => 'https://practice-hub.co.uk'],
        ['label' => 'Pop + Pixel — websites for HR consultants', 'href' => 'https://popandpixel.co.uk'],
    ],
    'Elsewhere' => [
        ['label' => 'LinkedIn', 'href' => 'https://www.linkedin.com/in/grace-pariser/'],
        ['label' => 'Qwoted (press &amp; media)', 'href' => 'https://app.qwoted.com/sources/grace-pariser'],
    ],
];
?>

<section class="hero wrap links-hero">
    <h1>Grace Pariser</h1>
    <p class="hero-role">Employment law &amp; HR &middot; Plymouth</p>
</section>

<section class="section wrap links-page" style="border-top:none;">
    <?php foreach ($groups as $heading => $links): ?>
        <div class="links-group">
            <p class="section-label"><?= htmlspecialchars($heading) ?></p>
            <?php foreach ($links as $l): $external = str_starts_with($l['href'], 'http'); ?>
                <a class="links-btn" href="<?= htmlspecialchars($l['href']) ?>"<?= $external ? ' target="_blank" rel="noopener"' : '' ?>><?= $l['label'] /* label may include &amp; */ ?></a>
            <?php endforeach; ?>
        </div>
    <?php endforeach; ?>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

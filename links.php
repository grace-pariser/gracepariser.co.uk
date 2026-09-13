<?php
// Standalone link-in-bio page. Deliberately does NOT use includes/header.php
// or includes/footer.php - no nav, no site chrome, just the page itself.
// Not in the main nav either - meant to be shared directly (social bios etc).

$products = [
    [
        'name' => 'HR On Call',
        'desc' => 'Employment law and HR consultancy for business owners.',
        'logo' => '/assets/images/products/hr-on-call.png',
        'href' => 'https://on-call.co.uk',
    ],
    [
        'name' => 'The HR Vault',
        'desc' => 'The back office of an HR consultancy, in one subscription.',
        'logo' => '/assets/images/products/hr-vault.webp',
        'href' => 'https://thehrvault.co.uk',
    ],
    [
        'name' => 'Practice Hub',
        'desc' => 'Practice management built for how HR consultants actually work.',
        'logo' => '/assets/images/products/practice-hub.png',
        'href' => 'https://practice-hub.co.uk',
    ],
    [
        'name' => 'Pop + Pixel',
        'desc' => 'Websites for HR consultants.',
        'logo' => '/assets/images/products/pop-pixel.png',
        'href' => 'https://popandpixel.co.uk',
    ],
];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Grace Pariser | Links</title>
<meta name="description" content="All my pages, products and profiles in one place.">
<link rel="icon" href="/assets/images/favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;0,8..60,700;1,8..60,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css?v=<?= @filemtime(__DIR__ . '/assets/css/style.css') ?: 1 ?>">
</head>
<body>
<main>

<section class="hero wrap links-hero">
    <h1>Grace Pariser</h1>
    <p class="hero-role">Employment Law | HR | Tech for HR</p>
</section>

<section class="section wrap links-page" style="border-top:none;">
    <a class="links-btn links-btn-primary" href="/contact.php">Get in touch</a>

    <div class="links-group">
        <a class="product-card" href="https://gracepariser.co.uk/">
            <span class="product-text">
                <span class="product-name">My website</span>
                <span class="product-desc">About me, press, writing, and how to work with me.</span>
            </span>
        </a>
        <a class="product-card" href="https://gracepariser.co.uk/writing.php">
            <span class="product-text">
                <span class="product-name">Writing</span>
                <span class="product-desc">Employment law and HR, written in my own words.</span>
            </span>
        </a>
        <a class="product-card" href="https://www.thehrvault.co.uk/legal-updates.php" target="_blank" rel="noopener">
            <span class="product-text">
                <span class="product-name">Employment Legal Updates</span>
                <span class="product-desc">Tracked changes in UK employment law, from The HR Vault.</span>
            </span>
        </a>
    </div>

    <div class="links-group">
        <p class="section-label">Products &amp; services</p>
        <?php foreach ($products as $p): ?>
            <a class="product-card" href="<?= htmlspecialchars($p['href']) ?>" target="_blank" rel="noopener">
                <span class="product-text">
                    <span class="product-name"><?= htmlspecialchars($p['name']) ?></span>
                    <span class="product-desc"><?= htmlspecialchars($p['desc']) ?></span>
                </span>
                <img class="product-logo" src="<?= htmlspecialchars($p['logo']) ?>" alt="<?= htmlspecialchars($p['name']) ?>">
            </a>
        <?php endforeach; ?>
    </div>

    <div class="links-group">
        <p class="section-label">Elsewhere</p>
        <a class="product-card" href="https://www.linkedin.com/in/grace-pariser/" target="_blank" rel="noopener">
            <span class="product-text">
                <span class="product-name">LinkedIn</span>
            </span>
            <img class="product-logo" src="/assets/images/products/linkedin.svg" alt="LinkedIn">
        </a>
        <a class="product-card" href="https://app.qwoted.com/sources/grace-pariser" target="_blank" rel="noopener">
            <span class="product-text">
                <span class="product-name">Qwoted</span>
                <span class="product-desc">Press &amp; media requests</span>
            </span>
            <img class="product-logo" src="/assets/images/products/qwoted.svg" alt="Qwoted">
        </a>
    </div>
</section>

</main>
</body>
</html>

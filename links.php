<?php
// Standalone link-in-bio page. Deliberately does NOT use includes/header.php
// or includes/footer.php - no nav, no site chrome, just the page itself.
// Not in the main nav either - meant to be shared directly (social bios etc).

$products = [
    [
        'name' => 'HR On Call',
        'desc' => 'Retainer support and one-off advice for business owners.',
        'logo' => '/assets/images/products/hr-on-call.webp',
        'href' => 'https://hr.on-call.co.uk',
    ],
    [
        'name' => 'The HR Vault',
        'desc' => 'The back office of an HR consultancy, in one subscription.',
        'logo' => '/assets/images/products/hr-vault.webp',
        'href' => 'https://thehrvault.co.uk',
    ],
    [
        'name' => 'Practice Hub',
        'desc' => 'Practice management built for independent HR consultants.',
        'logo' => '/assets/images/products/practice-hub.webp',
        'href' => 'https://practice-hub.co.uk',
    ],
    [
        'name' => 'Pop + Pixel',
        'desc' => 'Websites for HR consultancies, built by a working HR consultant.',
        'logo' => '/assets/images/products/pop-pixel.webp',
        'href' => 'https://popandpixel.co.uk',
    ],
    [
        'name' => 'Handbook Portal (business owners)',
        'desc' => "Upload the handbook you already have in Word and get a beautiful online portal in your company's brand.",
        'logo' => '/assets/images/products/handbook-portal.webp',
        'href' => 'https://handbookportal.co.uk',
    ],
    [
        'name' => 'Handbook Portal (HR consultants)',
        'desc' => "Turn any Word handbook into a beautiful online portal in your client's brand.",
        'logo' => '/assets/images/products/handbook-portal.webp',
        'href' => 'https://handbookportal.co.uk/resellers.php',
    ],
];
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Grace Pariser | Links</title>
<meta name="description" content="All my pages, products and profiles in one place.">
<link rel="canonical" href="https://gracepariser.co.uk/links.php">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Grace Pariser">
<meta property="og:title" content="Grace Pariser | Links">
<meta property="og:description" content="All my pages, products and profiles in one place.">
<meta property="og:url" content="https://gracepariser.co.uk/links.php">
<meta property="og:image" content="https://gracepariser.co.uk/assets/images/favicon-512x512.png">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Grace Pariser | Links">
<meta name="twitter:description" content="All my pages, products and profiles in one place.">
<meta name="twitter:image" content="https://gracepariser.co.uk/assets/images/favicon-512x512.png">
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
                <span class="product-desc">My bio, press, writing, and how to work with me.</span>
            </span>
        </a>
        <a class="product-card" href="https://gracepariser.co.uk/writing.php">
            <span class="product-text">
                <span class="product-name">Writing</span>
                <span class="product-desc">My personal thoughts on HR and the Employment Rights Act.</span>
            </span>
        </a>
        <a class="product-card" href="https://www.thehrvault.co.uk/legal-updates.php" target="_blank" rel="noopener">
            <span class="product-text">
                <span class="product-name">Employment Legal Updates</span>
                <span class="product-desc">What's actually changing in employment law, kept up to date on The HR Vault.</span>
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

    <ul class="footer-legal-links links-legal-links">
        <li><a href="/terms.php">Terms</a></li>
        <li><a href="/privacy-policy.php">Privacy notice</a></li>
        <li><a href="/cookies.php">Cookies</a></li>
    </ul>
</section>

</main>
</body>
</html>

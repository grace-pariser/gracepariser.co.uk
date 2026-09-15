<?php
// Expects $pageTitle, $pageDescription, $activeNav to be set by the caller.
$pageTitle = $pageTitle ?? 'Grace Pariser';
$pageDescription = $pageDescription ?? 'Employment law and HR consultant, Plymouth.';
$activeNav = $activeNav ?? '';
$noIndex = $noIndex ?? false;
$ogImage = $ogImage ?? 'https://gracepariser.co.uk/assets/images/og-image.png';

$canonicalPath = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
if ($canonicalPath === '/index.php') { $canonicalPath = '/'; }
$canonicalUrl = 'https://gracepariser.co.uk' . $canonicalPath;

function nav_class(string $key, string $active): string {
    return $key === $active ? ' class="is-active"' : '';
}
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle) ?></title>
<meta name="description" content="<?= htmlspecialchars($pageDescription) ?>">
<link rel="canonical" href="<?= htmlspecialchars($canonicalUrl) ?>">
<?php if ($noIndex): ?>
<meta name="robots" content="noindex,follow">
<?php endif; ?>

<meta property="og:type" content="website">
<meta property="og:site_name" content="Grace Pariser">
<meta property="og:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta property="og:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta property="og:url" content="<?= htmlspecialchars($canonicalUrl) ?>">
<meta property="og:image" content="<?= htmlspecialchars($ogImage) ?>">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="<?= htmlspecialchars($pageTitle) ?>">
<meta name="twitter:description" content="<?= htmlspecialchars($pageDescription) ?>">
<meta name="twitter:image" content="<?= htmlspecialchars($ogImage) ?>">

<link rel="icon" href="/assets/images/favicon.ico" sizes="any">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/images/favicon-16x16.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/images/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="192x192" href="/assets/images/favicon-192x192.png">
<link rel="apple-touch-icon" href="/assets/images/favicon-192x192.png">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400;0,8..60,600;0,8..60,700;1,8..60,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/css/style.css?v=<?= @filemtime(__DIR__ . '/../assets/css/style.css') ?: 1 ?>">

<script type="application/ld+json">
<?= json_encode([
    '@context' => 'https://schema.org',
    '@graph' => [
        [
            '@type' => 'Person',
            '@id' => 'https://gracepariser.co.uk/#person',
            'name' => 'Grace Pariser',
            'url' => 'https://gracepariser.co.uk/',
            'jobTitle' => 'Employment Law and HR Consultant',
            'description' => 'Employment law and HR consultant based in Plymouth, and owner of HR On Call Ltd.',
            'worksFor' => ['@id' => 'https://gracepariser.co.uk/#organization'],
            'knowsAbout' => ['Employment Law', 'HR Consultancy', 'TUPE', 'Settlement Agreements', 'Disciplinary Process', 'Employment Rights Bill'],
            'alumniOf' => [
                [
                    '@type' => 'CollegeOrUniversity',
                    'name' => 'University of Plymouth',
                ],
            ],
            'hasCredential' => [
                [
                    '@type' => 'EducationalOccupationalCredential',
                    'credentialCategory' => 'professional certification',
                    'name' => 'Chartered Member, CIPD',
                ],
                [
                    '@type' => 'EducationalOccupationalCredential',
                    'credentialCategory' => 'degree',
                    'name' => 'MA Human Resource Management, University of Plymouth',
                ],
            ],
            'homeLocation' => [
                '@type' => 'Place',
                'name' => 'Plymouth, UK',
            ],
            'sameAs' => [
                'https://www.linkedin.com/in/grace-pariser/',
                'https://app.qwoted.com/sources/grace-pariser',
            ],
        ],
        [
            '@type' => 'Organization',
            '@id' => 'https://gracepariser.co.uk/#organization',
            'name' => 'HR On Call Ltd',
            'url' => 'https://on-call.co.uk',
            'founder' => ['@id' => 'https://gracepariser.co.uk/#person'],
            'areaServed' => 'Plymouth, Devon, UK',
            'sameAs' => [
                'https://find-and-update.company-information.service.gov.uk/company/16891106',
                'https://www.linkedin.com/company/hr-on-call-ltd/',
            ],
        ],
        [
            '@type' => 'WebSite',
            '@id' => 'https://gracepariser.co.uk/#website',
            'name' => 'Grace Pariser',
            'url' => 'https://gracepariser.co.uk/',
            'publisher' => ['@id' => 'https://gracepariser.co.uk/#person'],
            'inLanguage' => 'en-GB',
        ],
        [
            '@type' => 'WebPage',
            '@id' => $canonicalUrl . '#webpage',
            'url' => $canonicalUrl,
            'name' => $pageTitle,
            'isPartOf' => ['@id' => 'https://gracepariser.co.uk/#website'],
            'about' => ['@id' => 'https://gracepariser.co.uk/#person'],
            'inLanguage' => 'en-GB',
        ],
    ],
], JSON_UNESCAPED_SLASHES) ?>
</script>
</head>
<body>
<header class="site-header">
  <div class="wrap masthead-row">
    <a class="wordmark" href="/">Grace Pariser</a>
    <p class="masthead-tag"><span>Employment Law</span><span>HR</span><span>Tech for HR</span></p>
    <button class="nav-toggle" id="nav-toggle" aria-label="Menu" aria-expanded="false" aria-controls="site-nav">Menu</button>
  </div>
  <div class="wrap nav-row">
    <nav class="site-nav" id="site-nav">
      <a href="/about.php"<?= nav_class('about', $activeNav) ?>>About</a>
      <a href="/press.php"<?= nav_class('press', $activeNav) ?>>Press</a>
      <a href="/writing.php"<?= nav_class('writing', $activeNav) ?>>Writing</a>
      <a href="/work-with-me.php"<?= nav_class('work', $activeNav) ?>>Work with me</a>
      <a href="/contact.php" class="nav-contact<?= $activeNav === 'contact' ? ' is-active' : '' ?>">Contact</a>
    </nav>
  </div>
</header>
<main>

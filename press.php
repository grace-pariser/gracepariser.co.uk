<?php
$pageTitle = 'Press | Grace Pariser';
$pageDescription = 'Employment law and HR commentary for national and trade press.';
$activeNav = 'press';
require __DIR__ . '/includes/header.php';

$featured = [
    [
        'outlet' => 'The Telegraph',
        'logo' => '/assets/images/press/telegraph.svg',
        'logoClass' => 'press-logo-telegraph',
        'date' => 'September 2026',
        'title' => 'Sorry, but your company really does need HR',
        'body' => 'As-told-to piece making the case that HR remains essential, prompted by a tech CEO firing his entire HR department and calling it unnecessary.',
        'href' => 'https://www.telegraph.co.uk/gift/463a3d80be760008',
    ],
    [
        'outlet' => 'Personnel Today',
        'logo' => '/assets/images/press/personnel-today.png',
        'logoClass' => 'press-logo-pt',
        'date' => 'June 2025',
        'title' => 'Seven ways to prepare now for the Employment Rights Bill',
        'body' => 'Commented on why employers should hold off changing contracts until secondary legislation is clearer.',
        'href' => 'https://www.personneltoday.com/hr/prepare-employment-rights-bill/',
    ],
    [
        'outlet' => 'Personnel Today',
        'logo' => '/assets/images/press/personnel-today.png',
        'logoClass' => 'press-logo-pt',
        'date' => 'October 2024',
        'title' => 'Bereavement leave: understanding the value of employer support',
        'body' => 'Commented on flexible return-to-work approaches for grieving employees.',
        'href' => 'https://www.personneltoday.com/hr/bereavement-leave-understanding-the-value-of-employer-support/',
    ],
];
?>

<section class="hero wrap">
    <div class="split">
        <div>
            <h1>Press</h1>
            <div class="prose lede">
                <p>I comment on employment law and HR for national and trade press.</p>
                <p>If you're working on something in this space, I'm easy to reach. And I don't take three days to get back to you.</p>
            </div>
        </div>
        <div class="panel changes-panel">
            <p class="section-label">What I can speak about</p>
            <ul class="changes-list">
                <li>The Employment Rights Bill and the wider Making Work Pay agenda</li>
                <li>The new Fair Work Agency</li>
                <li>TUPE, redundancy, disciplinary process, settlement agreements</li>
                <li>Whether businesses still need HR (I have views)</li>
                <li>The politics behind employment law and workplace policy</li>
            </ul>
        </div>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">Featured in</p>
    <div class="card-grid">
        <?php foreach ($featured as $i => $f): ?>
            <div class="article-card">
                <img src="<?= htmlspecialchars($f['logo']) ?>" alt="<?= htmlspecialchars($f['outlet']) ?>" class="press-logo <?= htmlspecialchars($f['logoClass']) ?>" style="margin-bottom:0.75em;">
                <?php if ($f['date']): ?><p class="article-meta"><?= htmlspecialchars($f['date']) ?></p><?php endif; ?>
                <h3><a href="<?= htmlspecialchars($f['href']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars($f['title']) ?></a></h3>
                <p><?= htmlspecialchars($f['body']) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section wrap">
    <div class="panel-ink">
        <p class="section-label">Get in touch</p>
        <div class="cta-row" style="margin-top:0;">
            <a class="btn" href="/contact.php">Contact form</a>
            <a class="btn-quiet" href="mailto:enquiries@gracepariser.co.uk">enquiries@gracepariser.co.uk</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

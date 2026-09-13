<?php
$pageTitle = 'Press — Grace Pariser';
$pageDescription = 'Employment law and HR commentary for national and trade press.';
$activeNav = 'press';
require __DIR__ . '/includes/header.php';

$featured = [
    [
        'outlet' => 'The Telegraph',
        'date' => 'September 2026',
        'title' => 'Sorry, but your company really does need HR',
        'body' => 'As-told-to piece making the case that HR remains essential, prompted by a tech CEO firing his entire HR department and calling it unnecessary.',
    ],
    [
        'outlet' => 'Personnel Today',
        'date' => null,
        'title' => 'Seven ways to prepare now for the Employment Rights Bill',
        'body' => 'Commented on why employers should hold off changing contracts until secondary legislation is clearer.',
    ],
    [
        'outlet' => 'Personnel Today',
        'date' => null,
        'title' => 'Bereavement leave: understanding the value of employer support',
        'body' => 'Commented on flexible return-to-work approaches for grieving employees.',
    ],
];
?>

<section class="hero wrap">
    <h1>Press</h1>
    <div class="prose lede">
        <p>I comment on employment law and HR for national and trade press. If you're working on something in this space, I'm easy to reach and I don't take three days to get back to you.</p>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">Featured in</p>
    <div class="card-grid">
        <?php foreach ($featured as $i => $f): ?>
            <div class="article-card">
                <span class="index-mark">No. <?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></span>
                <h3><?= htmlspecialchars($f['title']) ?></h3>
                <p><?= htmlspecialchars($f['body']) ?></p>
                <p class="article-meta"><?= htmlspecialchars(implode(' · ', array_filter([$f['outlet'], $f['date']]))) ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">What I can speak to</p>
    <div class="prose">
        <ul>
            <li>The Employment Rights Bill and the wider Making Work Pay agenda</li>
            <li>The new Fair Work Agency</li>
            <li>TUPE, redundancy, disciplinary process, settlement agreements</li>
            <li>Whether businesses still need HR (I have views)</li>
        </ul>
    </div>
</section>

<section class="section wrap">
    <div class="panel-ink">
        <p class="section-label">Get in touch</p>
        <div class="cta-row" style="margin-top:0;">
            <a class="btn" href="/contact.php">Contact form</a>
            <a class="btn-quiet" href="mailto:grace@on-call.co.uk">grace@on-call.co.uk</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

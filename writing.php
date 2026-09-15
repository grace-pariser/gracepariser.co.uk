<?php
$pageTitle = 'Writing | Grace Pariser';
$pageDescription = 'Employment law and HR, written the way I would actually explain it to you over coffee.';
$activeNav = 'writing';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/article-card.php';
$articles = require __DIR__ . '/includes/articles.php';
?>

<section class="hero wrap">
    <div class="split">
        <div>
            <h1>Writing</h1>
            <div class="prose lede">
                <p>Employment law and HR, written the way I'd actually explain it to you over coffee, not the legal-speak version.</p>
                <p>Sometimes it's a straightforward legal update. Sometimes it's me having a rant about something I think is ridiculous. Usually it's somewhere in between.</p>
            </div>
        </div>
        <div class="panel changes-panel">
            <p class="section-label">Topics I cover</p>
            <ul class="changes-list">
                <li>The Employment Rights Bill and Making Work Pay</li>
                <li>The new Fair Work Agency</li>
                <li>TUPE, redundancy, disciplinary process, settlement agreements</li>
                <li>Whether businesses still need HR</li>
            </ul>
            <div class="cta-row">
                <a class="btn-quiet" href="/press.php">Press &amp; speaking</a>
            </div>
        </div>
    </div>
</section>

<section class="section wrap" style="border-top:none;">
    <div class="card-grid<?= count($articles) < 3 ? ' card-grid-2' : '' ?>">
        <?php foreach ($articles as $a): render_article_card($a); endforeach; ?>
    </div>
</section>

<?php $linkedinFeedLead = false; require __DIR__ . '/includes/linkedin-feed-section.php'; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>

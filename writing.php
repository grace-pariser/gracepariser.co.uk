<?php
$pageTitle = 'Writing | Grace Pariser';
$pageDescription = 'Employment law and HR, written the way I would actually explain it to you over coffee.';
$activeNav = 'writing';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/article-card.php';
$articles = require __DIR__ . '/includes/articles.php';
?>

<section class="hero wrap">
    <h1>Writing</h1>
    <div class="prose lede">
        <p>Employment law and HR, written the way I'd actually explain it to you over coffee, not the legal-speak version.</p>
        <p>Sometimes it's a straightforward legal update. Sometimes it's me having a rant about something I think is ridiculous. Usually it's somewhere in between.</p>
    </div>
</section>

<section class="section wrap" style="border-top:none;">
    <div class="card-grid">
        <?php foreach ($articles as $i => $a): render_article_card($a, $i + 1); endforeach; ?>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php
$pageTitle = 'Grace Pariser — Employment law and HR consultant';
$pageDescription = "I'm Grace Pariser, an employment law and HR consultant based in Plymouth, and owner of HR On Call Ltd.";
$activeNav = '';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/article-card.php';
$articles = require __DIR__ . '/includes/articles.php';
?>

<section class="hero wrap">
    <h1 class="hero-headline-long">I'm Grace Pariser, an employment law and HR consultant based in Plymouth, and owner of HR On Call Ltd.</h1>
    <div class="prose lede">
        <p>I've been doing this for the best part of a decade now, in-house and then on my own, and if there's one thing nine years has taught me it's that most people who've never had to run a disciplinary process think it's a lot simpler than it is.</p>
    </div>
    <div class="cta-row">
        <a class="btn" href="/press.php">Invite me to comment</a>
        <a class="btn-quiet" href="/writing.php">Read my writing</a>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">Why this matters right now</p>
    <div class="prose">
        <p>Employment law hasn't sat still in years, but this is a lot even by that standard. Day-one unfair dismissal rights, changes to redundancy consultation, a new Fair Work Agency with its own enforcement powers, and a Making Work Pay agenda that I think is achieving the opposite of what it says on the tin.</p>
    </div>
    <div class="pull-quote">
        <p>A Making Work Pay agenda that I think is achieving the opposite of what it says on the tin.</p>
    </div>
    <div class="prose">
        <p>Most employers are still working off rules that are about to change underneath them, and most won't find out until it's already gone wrong.</p>
    </div>
</section>

<section class="press-strip wrap">
    <p class="section-label">As seen in</p>
    <ul class="press-logos">
        <li><a href="https://www.telegraph.co.uk" target="_blank" rel="noopener"><img src="/assets/images/press/telegraph.svg" alt="The Telegraph" class="press-logo press-logo-telegraph"></a></li>
        <li><a href="https://www.personneltoday.com" target="_blank" rel="noopener"><img src="/assets/images/press/personnel-today.png" alt="Personnel Today" class="press-logo press-logo-pt"></a></li>
    </ul>
</section>

<section class="section wrap">
    <div class="split">
        <div>
            <p class="section-label">About</p>
            <div class="prose">
                <p>CIPD Level 7 qualified. I advise business owners on TUPE, settlement agreements, disciplinary processes, and whatever the Employment Rights Bill throws at them next. I've been the person a manager refuses to speak to for a week because they didn't like my advice, so I don't take it personally when I'm not popular. That's usually when I know I've said the right thing.</p>
            </div>
            <div class="cta-row">
                <a class="btn-quiet" href="/about.php">Full bio</a>
            </div>
        </div>
        <div class="photo-placeholder aspect-portrait">Photo: Grace Pariser</div>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">Recent writing</p>
    <div class="card-grid">
        <?php foreach ($articles as $i => $a): render_article_card($a, $i + 1); endforeach; ?>
    </div>
</section>

<section class="section wrap">
    <div class="panel-ink">
        <p class="section-label">For journalists</p>
        <div class="prose">
            <p>Working on a story about employment law, HR, or workplace rights? Get in touch. I'll give you a straight answer, even if it's not the one that makes for the tidiest headline.</p>
        </div>
        <div class="cta-row">
            <a class="btn" href="/contact.php">Get in touch</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

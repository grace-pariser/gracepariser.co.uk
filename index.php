<?php
$pageTitle = 'Grace Pariser | Employment law and HR consultant';
$pageDescription = "I'm Grace Pariser, an employment law and HR consultant based in Plymouth, and owner of HR On Call Ltd.";
$activeNav = '';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/article-card.php';
$articles = require __DIR__ . '/includes/articles.php';
$linkedinPosts = require __DIR__ . '/includes/linkedin-feed.php';
?>

<section class="hero wrap">
    <h1 class="hero-headline-long">I'm Grace Pariser. I'm an employment law and HR consultant based in Plymouth.</h1>
    <div class="prose lede">
        <p>I've been doing this for the best part of a decade now, first in-house and then on my own.</p>
        <p>And if there's one thing nine years of HR and employment law has taught me, it's that most people who've never had to deal with a disciplinary process think it's a lot simpler than it actually is.</p>
        <p>It isn't.</p>
        <p>There are rules, risks, difficult conversations, managers who want to do something you really don't think they should do, and employees who have suddenly discovered Google.</p>
        <p>I help employers work their way through all of that.</p>
    </div>
    <div class="cta-row">
        <a class="btn" href="/press.php">Invite me to comment</a>
        <a class="btn-quiet" href="/writing.php">Read my writing</a>
    </div>
</section>

<section class="press-strip wrap">
    <p class="section-label">My services and products</p>
    <ul class="press-logos">
        <li><a href="https://hr.on-call.co.uk" target="_blank" rel="noopener"><img src="/assets/images/products/hr-on-call.png" alt="HR On Call" class="press-logo press-logo-uniform"></a></li>
        <li><a href="https://thehrvault.co.uk" target="_blank" rel="noopener"><img src="/assets/images/products/hr-vault.webp" alt="The HR Vault" class="press-logo press-logo-uniform"></a></li>
        <li><a href="https://practice-hub.co.uk" target="_blank" rel="noopener"><img src="/assets/images/products/practice-hub.png" alt="Practice Hub" class="press-logo press-logo-uniform"></a></li>
        <li><a href="https://popandpixel.co.uk" target="_blank" rel="noopener"><img src="/assets/images/products/pop-pixel.png" alt="Pop + Pixel" class="press-logo press-logo-uniform"></a></li>
    </ul>
</section>

<section class="section wrap">
    <p class="section-label">Employment law is changing. A lot.</p>
    <div class="prose">
        <p>Employment law hasn't exactly sat still over the last few years, but there's a lot happening at the moment.</p>
        <p>Day-one unfair dismissal rights. A new Fair Work Agency with its own enforcement powers. And the wider Making Work Pay agenda, which I think is achieving the opposite of what it says on the tin.</p>
    </div>
    <div class="pull-quote">
        <p>A Making Work Pay agenda that I think is achieving the opposite of what it says on the tin.</p>
    </div>
    <div class="prose">
        <p>The problem for employers is that the law doesn't politely wait until everyone has caught up before changing again.</p>
        <p>There are businesses making decisions now based on rules that are about to change underneath them. And, as is usually the case with employment law, some people won't realise they've got it wrong until they're already dealing with the consequences.</p>
        <p>That's where I come in.</p>
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
            <p class="section-label">A bit about me</p>
            <div class="prose">
                <p>I'm CIPD Level 7 qualified and advise business owners on TUPE, settlement agreements, disciplinary processes and the various employment law changes that keep appearing.</p>
                <p>I've spent most of my career dealing with the things that employers would generally rather not deal with.</p>
                <p>Difficult employees. Difficult managers. Difficult decisions. And occasionally difficult lawyers.</p>
                <p>I've also been the person a manager refuses to speak to for a week because they didn't like my advice.</p>
                <p>I don't take it personally.</p>
                <p>Usually, that's when I know I've said the right thing.</p>
            </div>
            <div class="cta-row">
                <a class="btn-quiet" href="/about.php">Full bio</a>
            </div>
        </div>
        <div class="photo-placeholder aspect-portrait">Photo: Grace Pariser</div>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">I write about this stuff</p>
    <div class="prose">
        <p>I regularly write about employment law, HR and the things I think employers (and HR people) actually need to know.</p>
        <p>Sometimes it's a straightforward legal update.</p>
        <p>Sometimes it's me having a rant about something I think is ridiculous.</p>
        <p>Usually it's somewhere in between.</p>
    </div>
    <p class="section-label" style="margin-top:2.5rem; padding-top:2rem; border-top:1px solid var(--border);">Recent writing</p>
    <div class="card-grid">
        <?php foreach ($articles as $i => $a): render_article_card($a, $i + 1); endforeach; ?>
    </div>
</section>

<section class="section wrap">
    <p class="section-label">From LinkedIn</p>
    <div class="prose">
        <p>Shorter thoughts, posted more often, over on LinkedIn.</p>
    </div>
    <?php if ($linkedinPosts): ?>
    <ul class="linkedin-feed">
        <?php foreach (array_slice($linkedinPosts, 0, 4) as $post): ?>
        <li>
            <a href="<?= htmlspecialchars($post['url']) ?>" target="_blank" rel="noopener">
                <span class="linkedin-feed-date"><?= htmlspecialchars($post['date']) ?></span>
                <p><?= htmlspecialchars($post['text']) ?></p>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
    <?php endif; ?>
    <div class="cta-row">
        <a class="btn-quiet" href="https://www.linkedin.com/in/grace-pariser/" target="_blank" rel="noopener">Follow on LinkedIn</a>
    </div>
</section>

<section class="section wrap">
    <div class="panel-ink">
        <p class="section-label">For journalists</p>
        <div class="prose">
            <p>Working on a story about employment law, HR or workplace rights?</p>
            <p>Get in touch.</p>
            <p>I'll give you a straight answer.</p>
        </div>
        <div class="cta-row">
            <a class="btn" href="/contact.php">Get in touch</a>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

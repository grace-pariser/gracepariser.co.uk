<?php
$pageTitle = 'Contact | Grace Pariser';
$pageDescription = "Tell me what you need and I'll come back to you directly.";
$activeNav = 'contact';
require __DIR__ . '/includes/header.php';
require __DIR__ . '/includes/antispam.php';

$sent = isset($_GET['sent']);
$error = $_GET['error'] ?? null;
$antispamToken = antispam_token();
?>

<section class="hero wrap">
    <h1>Get in touch</h1>
    <div class="prose lede">
        <p>Whether it's a consultancy enquiry, a press request, or something else entirely, tell me a bit about it and I'll come back to you directly.</p>
    </div>
    <p class="form-note">Or email me directly at <a href="mailto:enquiries@gracepariser.co.uk">enquiries@gracepariser.co.uk</a>.</p>
</section>

<section class="section wrap" style="border-top:none; padding-top:1.5rem;">
    <div class="split">
        <div class="panel contact-panel">
            <p class="section-label">Send a message</p>

            <?php if ($sent): ?>
                <p class="form-status ok">Thanks, that's landed with me. I'll be in touch shortly.</p>
            <?php elseif ($error): ?>
                <p class="form-status err">Something went wrong sending that. Try again, or email <a href="mailto:enquiries@gracepariser.co.uk">enquiries@gracepariser.co.uk</a> directly.</p>
            <?php endif; ?>

            <form method="post" action="/process-contact.php">
                <div class="form-field hp-field" aria-hidden="true">
                    <label for="website">Leave this field blank</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>
                <input type="hidden" name="ts" value="<?= $antispamToken['ts'] ?>">
                <input type="hidden" name="sig" value="<?= htmlspecialchars($antispamToken['sig']) ?>">

                <div class="form-field">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-field">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-field">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" rows="6" required></textarea>
                </div>
                <button class="btn" type="submit">Send</button>
            </form>
        </div>

        <div>
            <p class="section-label">Other enquiries</p>
            <ul class="contact-elsewhere">
                <li><span>HR On Call</span><a href="mailto:hello@on-call.co.uk">hello@on-call.co.uk</a></li>
                <li><span>The HR Vault</span><a href="mailto:hello@thehrvault.co.uk">hello@thehrvault.co.uk</a></li>
                <li><span>Practice Hub</span><a href="mailto:hello@practice-hub.co.uk">hello@practice-hub.co.uk</a></li>
            </ul>
        </div>
    </div>
</section>

<?php require __DIR__ . '/includes/footer.php'; ?>

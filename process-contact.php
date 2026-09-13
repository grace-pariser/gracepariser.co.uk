<?php
// Contact form handler: honeypot + minimum-fill-time check, then emails
// the enquiry straight to Grace. No database, nothing stored.

function fail(string $reason): void {
    header('Location: /contact.php?error=' . urlencode($reason));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: /contact.php');
    exit;
}

// Honeypot: a real visitor never fills this in.
if (!empty($_POST['website'])) {
    fail('spam');
}

// A bot that fills and submits the form in under 3 seconds is suspicious.
$ts = (int)($_POST['ts'] ?? 0);
if ($ts <= 0 || (time() - $ts) < 3) {
    fail('spam');
}

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    fail('invalid');
}

$to = 'enquiries@gracepariser.co.uk';
$subject = 'gracepariser.co.uk enquiry from ' . $name;
$body = "Name: $name\nEmail: $email\n\n$message\n";
$headers = 'From: no-reply@gracepariser.co.uk' . "\r\n" .
           'Reply-To: ' . $email . "\r\n";

$ok = mail($to, $subject, $body, $headers);

if (!$ok) {
    fail('send-failed');
}

header('Location: /contact.php?sent=1');
exit;

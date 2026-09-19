<?php
// This page receives the contact form data sent with method="post".
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: contact.html');
    exit;
}

$name = trim($_POST['name'] ?? '');
$visitorEmail = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// Do not send an email if required details are missing or the email is invalid.
if ($name === '' || $subject === '' || $message === '' || !filter_var($visitorEmail, FILTER_VALIDATE_EMAIL)) {
    header('Location: contact.html?status=error');
    exit;
}

$to = '12muhammadalihassan@gmail.com';
$emailSubject = 'New Form Submission: ' . $subject;
$emailBody = "User Name: {$name}\n"
    . "User Email: {$visitorEmail}\n"
    . "Subject: {$subject}\n\n"
    . "Message:\n{$message}\n";

// Use an address from your own domain here. Reply-To lets you reply to the visitor.
$emailFrom = 'info@psyncs.com';
$headers = "From: {$emailFrom}\r\n";
$headers .= "Reply-To: {$visitorEmail}\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

$sent = mail($to, $emailSubject, $emailBody, $headers);

header('Location: contact.html?status=' . ($sent ? 'success' : 'error'));
exit;

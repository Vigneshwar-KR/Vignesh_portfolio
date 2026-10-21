<?php
  header('Content-Type: text/plain; charset=UTF-8');

  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Only POST requests are accepted.');
  }

  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $subject = trim($_POST['subject'] ?? '');
  $message = trim($_POST['message'] ?? '');

  if ($name === '' || $subject === '' || $message === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    exit('Please provide a name, valid email address, subject, and message.');
  }

  $receiving_email_address = 'vigneshwar.kr@gmail.com';
  $safe_subject = str_replace(["\r", "\n"], '', $subject);
  $body = "Name: {$name}\nEmail: {$email}\n\n{$message}";
  $headers = "From: {$name} <{$email}>\r\n";
  $headers .= "Reply-To: {$email}\r\n";
  $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

  if (!mail($receiving_email_address, $safe_subject, $body, $headers)) {
    http_response_code(500);
    exit('The message could not be sent. Please email vigneshwar.kr@gmail.com directly.');
  }

  echo 'OK';
?>

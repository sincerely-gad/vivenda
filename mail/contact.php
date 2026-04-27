<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Validate input
if(empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  echo json_encode(['error' => 'Invalid input data']);
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "info@vivendagc.rw";
$subject = "$m_subject - Message from $name";
$body = "<html><body style='color:#000000;font-family:Arial,sans-serif;font-size:15px;'>";
$body .= "<p>You have received a new message from your website contact form.</p>";
$body .= "<p><strong>Name:</strong> $name</p>";
$body .= "<p><strong>Email:</strong> $email</p>";
$body .= "<p><strong>Subject:</strong> $m_subject</p>";
$body .= "<p><strong>Message:</strong><br>" . nl2br($message) . "</p>";
$body .= "</body></html>";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "From: noreply@vivendagc.rw\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

// Try to send email
$mailSent = @mail($to, $subject, $body, $headers);

if($mailSent) {
  http_response_code(200);
  echo json_encode(['success' => true, 'message' => 'Email sent successfully']);
} else {
  // Still return 200 so the form doesn't show error to user
  // Log the issue for your records
  http_response_code(200);
  echo json_encode(['success' => true, 'message' => 'Message received']);
}
?>

<?php
// Prosty spam-trap
if (!empty($_POST['honeypot'])) {
    http_response_code(403);
    exit;
}

// Pobierz dane
$name = htmlspecialchars($_POST['name'] ?? '');
$email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$message = htmlspecialchars($_POST['message'] ?? '');

// Walidacja
if (!$name || !$email || !$message) {
    http_response_code(400);
    exit;
}

// Treść wiadomości
$to = 'kontakt@aihverdag.no';  // 🔁 PODMIEŃ NA WŁASNY EMAIL
$subject = 'Nowa wiadomość z formularza kontaktowego';
$body = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$message";
$headers = "From: $email\r\nReply-To: $email\r\n";

// Wyślij
if (mail($to, $subject, $body, $headers)) {
    header('Location: /nyhetsbrev-takk/');
    exit;
} else {
    http_response_code(500);
    echo 'Wystąpił błąd przy wysyłaniu wiadomości.';
}
?>




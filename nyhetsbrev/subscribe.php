<?php
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['error' => 'Nieprawidłowy adres e-mail.']);
    exit;
}

$email = $data['email'];
$group_id = "151960128260671064";  // Twój Group ID
$api_key = "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNWQ4ZTEwMjg5MjU2NTRkYjA5ODBlZTkzNjg3ZDU5MjA3MGJmYzJkMGZmMjFkM2UwZTM0MTg1YTBlYWY3YzYzNDI5NmUzYTNkNGMxOWZjOWUiLCJpYXQiOjE3NDUxODAxMTIuNjMyNzEsIm5iZiI6MTc0NTE4MDExMi42MzI3MTIsImV4cCI6NDkwMDg1MzcxMi42Mjg5OCwic3ViIjoiMTQ3Mzc2OCIsInNjb3BlcyI6W119.Nz-hlrGJLxRRhcsQS4HsWTKP86ryxECghvwti3AK1Vx0HNKaKFbZnVpcHtj5n2k49fKVNr3ZoFv2eAgILUI6vzq_qMf-t1U-nrfA_lP3Jrj9Oi037nKm32FbhD9DvKZiPtgDxyfK5JpfaKON5qzvNPKU99Wy_XNiGadK1MRDGfySJuRdKKABfO7SyLcf1XpnoLpfXLZi3XLMOOcFBPL_3CnpcFPTXIYS9eXfrryMsUc3jMmizqW_sYdq3sVmGkoNJwA3Xjm78fiPC4qwFSBvjaQBhfbaFX_2YIgrjZy7BUQfnugF4Iw4hto3gjMMGYPM_-lZMiXwDr-HSPKZ9W_tVJkFdIVX4UisvGct0KfrdehOfXs3y1NsLuVGthzmr8QtaPztyVgpT_pZZfptZOyzEdEfsYZHdnpmWXzDiMcHlXupyl8QW4u6FepgfTskPSGDPiXODlLpTobYJy-ueK5E9fNP58zHrYzv_DiTVAIhjay_sbYW9x2NNan5ob6tk04rWCPC7cAKqp5bAoxd59SYDkhxInWTNGnDUUr1gI1WqJKqaaaNfTg5n30bJKP5wiqP_hzoGCV7MUinM4rAWNS7L7MpXOO-JmUp0PpkBJXQ5XI_mpMwZEUTAzsSNclr57Uy7pkoxumfwdZGry5HRrhJlGt2b-pmqk2BOJRm9p4EzP4   ";  // <-- Podmień ręcznie na swój prawdziwy klucz

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://api.mailerlite.com/api/v2/groups/$group_id/subscribers");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['email' => $email]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "X-MailerLite-ApiKey: $api_key"
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code == 200 || $http_code == 201) {
    echo json_encode(['success' => true]);
} else {
    http_response_code($http_code);
    echo json_encode(['error' => 'Błąd podczas zapisu do newslettera.']);
}
?>

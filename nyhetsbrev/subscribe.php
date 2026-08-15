<?php
header('Content-Type: application/json');
http_response_code(410);
echo json_encode([
    'error' => 'Newsletter signup is temporarily unavailable.'
]);
?>

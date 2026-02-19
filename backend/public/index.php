<?php
// Сообщаем браузеру, что это JSON
header('Content-Type: application/json');

// Простой ответ
echo json_encode([
    'status' => 'success',
    'message' => 'PHP сервер работает!',
    'php_version' => phpversion(),
    'time' => date('Y-m-d H:i:s')
]);


// <!-- Роутинг: все запросы идут сюда -->
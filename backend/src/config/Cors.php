<?php
class Cors {
    // Разрешённые домены
    private static $allowedOrigins = [
        'http://localhost',
        'http://localhost:80',
        'http://localhost:5173'
    ];

    public static function setHeaders() {
        $origin = $_SERVER['HTTP_ORIGIN'] ?? '';

        // Проверяем, разрешён ли домен
        if (in_array($origin, self::$allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
        }

        // Основные заголовки
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); // Кэшируем preflight на 24 часа

        // Обрабатываем preflight
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }
}
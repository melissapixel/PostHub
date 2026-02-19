<?php
header('Content-Type: application/json');

// Получаем настройки из переменных окружения
$db_host = getenv('DB_HOST') ?: 'db';
$db_port = getenv('DB_PORT') ?: '5432';
$db_name = getenv('POSTGRES_DB') ?: 'myapp_db';
$db_user = getenv('POSTGRES_USER') ?: 'myapp_user';
$db_pass = getenv('POSTGRES_PASSWORD') ?: 'myapp_secret_password';

$dsn = "pgsql:host=$db_host;port=$db_port;dbname=$db_name";

try {
    // Подключение к БД
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Тестовый запрос
    $stmt = $pdo->query("SELECT * FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'message' => 'Подключение к PostgreSQL успешно!',
        'database' => $db_name,
        'users_count' => count($users),
        'users' => $users
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Ошибка подключения к БД',
        'error' => $e->getMessage()
    ]);
}
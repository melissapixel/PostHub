<?php
require_once __DIR__ . '/../src/config/Database.php';

try {
    $pdo = Database::getInstance()->getConnection();
    
    // Проверяем кодировку (для PostgreSQL)
    $stmt = $pdo->query("SHOW CLIENT_ENCODING");
    $encoding = $stmt->fetch();
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Connection established',
        'client_encoding' => $encoding['client_encoding'] ?? 'unknown'
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
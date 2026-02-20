<?php
// Получаем путь (например, /api/posts или /api/posts/first-post)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Убираем префикс /api, если он есть
$uri = str_replace('/api', '', $uri);

// Разбиваем путь на части
$parts = explode('/', trim($uri, '/'));
$resource = $parts[0] ?? '';
$id = $parts[1] ?? null;

if ($resource === 'posts' && !$id) {
    require_once __DIR__ . '/../src/controllers/PostController.php';
    $controller = new PostController();
    $controller->index();
} 
elseif ($resource === 'posts' && $id) {
    require_once __DIR__ . '/../src/controllers/PostController.php';
    $controller = new PostController();
    $controller->show($id);
}
elseif ($resource === 'categories') {
    require_once __DIR__ . '/../src/controllers/CategoryController.php';
    $controller = new CategoryController();
    $controller->index();
}
else {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Not found']);
}
<?php
require_once __DIR__ . '/../models/PostModel.php';

class PostController {
    private $model;

    public function __construct() {
        $this->model = new PostModel();
    }

    public function index() {
        $data = $this->model->getAll();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $data]);
    }

    public function show($slug) {
        $data = $this->model->getBySlug($slug);
        header('Content-Type: application/json');
        if ($data) {
            echo json_encode(['status' => 'success', 'data' => $data]);
        } else {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'message' => 'Post not found']);
        }
    }
}
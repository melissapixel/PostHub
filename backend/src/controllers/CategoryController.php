<?php
require_once __DIR__ . '/../models/CategoryModel.php';

class CategoryController {
    private $model;

    public function __construct() {
        $this->model = new CategoryModel();
    }

    public function index() {
        $data = $this->model->getAll();
        header('Content-Type: application/json');
        echo json_encode(['status' => 'success', 'data' => $data]);
    }
}
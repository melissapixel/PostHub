<?php
require_once __DIR__ . '/../config/Database.php';

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM category ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM category WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
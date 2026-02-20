<?php
require_once __DIR__ . '/../config/Database.php';

class PostModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        // Получаем посты вместе с названием категории
        $stmt = $this->db->query("
            SELECT p.*, c.name as category_name 
            FROM post p 
            LEFT JOIN category c ON p.category_id = c.id 
            ORDER BY p.created_at DESC
        ");
        return $stmt->fetchAll();
    }

    public function getBySlug($slug) {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name as category_name, c.slug as category_slug 
            FROM post p 
            LEFT JOIN category c ON p.category_id = c.id 
            WHERE p.slug = :slug
        ");
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO post (title, slug, anons, category_id, about) 
            VALUES (:title, :slug, :anons, :category_id, :about)
        ");
        return $stmt->execute($data);
    }
}
<?php
namespace Api\Services;

use PDO;

class CourseService {
    protected PDO $db;
    protected string $table = 'courses';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllCourses(): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCourseById(string $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getCoursesByCategory(string $categoryId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
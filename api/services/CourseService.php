<?php

namespace Api\Services;

require_once 'services/BaseService.php';
use PDO;

class CourseService extends BaseService
{

    protected string $table = 'courses';
    protected string $categoriesTable = 'categories';

    public function getCoursesByCategory(string $categoryId): array
    {
        $stmt = $this->db->prepare("
        SELECT * FROM $this->table WHERE category_id IN (
            SELECT id from $this->categoriesTable WHERE id=:categoryId 
            UNION SELECT id from $this->categoriesTable WHERE parent_id = :categoryId
            UNION SELECT id from $this->categoriesTable WHERE parent_id IN (
                SELECT id from $this->categoriesTable WHERE parent_id = :categoryId) 
            UNION SELECT id from $this->categoriesTable where parent_id IN (
                SELECT id from $this->categoriesTable WHERE parent_id IN (
                    SELECT id from $this->categoriesTable WHERE parent_id = :categoryId)))
        ");
        $stmt->execute(['categoryId' => $categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

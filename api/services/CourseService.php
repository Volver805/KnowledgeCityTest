<?php
namespace Api\Services;

require_once 'services/BaseService.php';

use PDO;

class CourseService extends BaseService {
    protected string $table = 'courses';

    public function getCoursesByCategory(string $categoryId): array
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
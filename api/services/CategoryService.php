<?php

namespace Api\Services;

use PDO;

require_once 'services/BaseService.php';

class CategoryService extends BaseService
{
    protected $coursesTable = 'courses';

    public function getAll()
    {

        $stmt = $this->db->prepare("SELECT c1.*, COALESCE(COUNT($this->coursesTable.category_id), 0) AS course_count
        FROM $this->table AS c1 
        LEFT JOIN $this->coursesTable AS courses ON courses.category_id = c1.id OR courses.category_id IN (
            SELECT id FROM $this->table WHERE parent_id = c1.id OR parent_id IN (
                SELECT id FROM $this->table WHERE parent_id = c1.id OR parent_id IN (
                        SELECT id FROM $this->table WHERE parent_id = c1.id
                    )
            )
        ) GROUP BY c1.id;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    protected string $table = 'categories';
}

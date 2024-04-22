<?php
namespace Api\Services;

use PDO;

class BaseService {
    protected PDO $db;
    protected string $table = '';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        
        $stmt = $this->db->prepare("SELECT * FROM $this->table");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(string $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
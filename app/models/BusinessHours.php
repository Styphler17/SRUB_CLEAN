<?php

namespace App\Models;

use PDO;

class BusinessHours extends Model
{
    protected $table = 'business_hours';
    public function getAll()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')";
        $stmt = $this->connexion->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

<?php

namespace App\Models;

use PDO;

class ContactInfo extends Model
{
    protected $table = 'contact_info';
    public function getInfo()
    {
        $sql = "SELECT *, JSON_UNQUOTE(phone_numbers) as phone_numbers FROM {$this->table} ORDER BY id ASC LIMIT 1";
        $stmt = $this->connexion->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Convert phone_numbers from JSON string to array
        if ($result && isset($result['phone_numbers'])) {
            $result['phone_numbers'] = json_decode($result['phone_numbers'], true) ?? [];
        } else {
            $result['phone_numbers'] = [];
        }

        return $result;
    }
}

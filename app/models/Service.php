<?php

namespace App\Models;

use PDO;

class Service extends Model
{
    protected $table = 'services';

    public function getActiveServices()
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE is_active = 1";
            $query = $this->connexion->prepare($sql);
            $query->execute();
            $services = $query->fetchAll(PDO::FETCH_ASSOC);
            // Fix image_url paths
            foreach ($services as &$service) {
                if (isset($service['image_url']) && strpos($service['image_url'], '/images/services/') === 0) {
                    $service['image_url'] = '/assets' . $service['image_url'];
                }
            }
            return $services;
        } catch (\PDOException $e) {
            error_log("Error in Service::getActiveServices: " . $e->getMessage());
            throw new \Exception("Failed to fetch active services");
        }
    }
}

<?php

namespace App\Models;

use PDO;

class Review extends Model
{
    protected $table = 'reviews';

    public function getAllReviews()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->connexion->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLatestReviews($limit = 3)
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        $stmt = $this->connexion->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createReview($data)
    {
        try {
            $sql = "INSERT INTO reviews (name, rating, comment, created_at) VALUES (:name, :rating, :comment, NOW())";
            $stmt = $this->connexion->prepare($sql);
            return $stmt->execute([
                'name' => $data['name'],
                'rating' => $data['rating'],
                'comment' => $data['comment']
            ]);
        } catch (\PDOException $e) {
            error_log('Error in Review::createReview: ' . $e->getMessage());
            return false;
        }
    }
}

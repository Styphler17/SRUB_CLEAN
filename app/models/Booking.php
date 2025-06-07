<?php

namespace App\Models;

class Booking extends Model
{
    protected $table = 'bookings';

    public function createBooking($data)
    {
        try {
            $sql = "INSERT INTO bookings (user_id, service_id, booking_date, start_time, end_time, total_price, special_instructions, status) 
                    VALUES (:user_id, :service_id, :booking_date, :start_time, :end_time, :total_price, :special_instructions, :status)";
            $query = $this->connexion->prepare($sql);
            return $query->execute($data);
        } catch (\PDOException $e) {
            error_log("Error in Booking::createBooking: " . $e->getMessage());
            throw new \Exception("Failed to create booking. Please try again later.");
        }
    }

    public function getBookingById($id)
    {
        try {
            $sql = "SELECT b.*, s.name as service_name, s.price as service_price 
                    FROM bookings b 
                    JOIN services s ON b.service_id = s.id 
                    WHERE b.id = :id";
            $query = $this->connexion->prepare($sql);
            $query->execute(['id' => $id]);
            return $query->fetch(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Booking::getBookingById: " . $e->getMessage());
            throw new \Exception("Failed to retrieve booking details.");
        }
    }

    public function getUserBookings($userId)
    {
        try {
            $sql = "SELECT b.*, s.name as service_name, s.price as service_price 
                    FROM bookings b 
                    JOIN services s ON b.service_id = s.id 
                    WHERE b.user_id = :user_id 
                    ORDER BY b.booking_date DESC";
            $query = $this->connexion->prepare($sql);
            $query->execute(['user_id' => $userId]);
            return $query->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Error in Booking::getUserBookings: " . $e->getMessage());
            throw new \Exception("Failed to retrieve user bookings.");
        }
    }

    public function updateBookingStatus($id, $status)
    {
        try {
            $sql = "UPDATE bookings SET status = :status WHERE id = :id";
            $query = $this->connexion->prepare($sql);
            return $query->execute(['id' => $id, 'status' => $status]);
        } catch (\PDOException $e) {
            error_log("Error in Booking::updateBookingStatus: " . $e->getMessage());
            throw new \Exception("Failed to update booking status.");
        }
    }

    public function checkAvailability($date, $startTime, $endTime)
    {
        try {
            $sql = "SELECT COUNT(*) FROM bookings 
                    WHERE booking_date = :date 
                    AND ((start_time <= :end_time AND end_time >= :start_time)
                    OR (start_time >= :start_time AND start_time < :end_time)
                    OR (end_time > :start_time AND end_time <= :end_time))";
            $query = $this->connexion->prepare($sql);
            $query->execute([
                'date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
            return $query->fetchColumn() === 0;
        } catch (\PDOException $e) {
            error_log("Error in Booking::checkAvailability: " . $e->getMessage());
            throw new \Exception("Failed to check booking availability.");
        }
    }
}

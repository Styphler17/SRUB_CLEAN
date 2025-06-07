<?php

namespace App\Controllers;

use App\Models\Booking;
use App\Models\Service;

class BookingController extends Controller
{
    public function index()
    {
        try {
            $serviceModel = new Service();
            $services = $serviceModel->getActiveServices();

            $this->render('pages/booking', [
                'services' => $services,
                'error' => $_GET['error'] ?? null,
                'success' => $_GET['success'] ?? null
            ]);
        } catch (\Exception $e) {
            error_log("Error in BookingController::index: " . $e->getMessage());
            $this->render('pages/booking', [
                'services' => [],
                'error' => 'An error occurred while loading services. Please try again later.'
            ]);
        }
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ./index.php?page=booking&error=Invalid request method');
            exit;
        }

        try {
            // Validate required fields
            $requiredFields = ['service_id', 'booking_date', 'start_time', 'end_time', 'total_price'];
            foreach ($requiredFields as $field) {
                if (empty($_POST[$field])) {
                    throw new \Exception("Missing required field: {$field}");
                }
            }

            // Validate date and time
            $bookingDate = new \DateTime($_POST['booking_date']);
            $startTime = new \DateTime($_POST['start_time']);
            $endTime = new \DateTime($_POST['end_time']);

            if ($bookingDate < new \DateTime('today')) {
                throw new \Exception("Booking date cannot be in the past");
            }

            if ($startTime >= $endTime) {
                throw new \Exception("End time must be after start time");
            }

            $bookingModel = new Booking();
            $data = [
                'user_id' => $_SESSION['user_id'] ?? null,
                'service_id' => $_POST['service_id'],
                'booking_date' => $_POST['booking_date'],
                'start_time' => $_POST['start_time'],
                'end_time' => $_POST['end_time'],
                'total_price' => $_POST['total_price'],
                'special_instructions' => $_POST['special_instructions'] ?? null,
                'status' => 'pending'
            ];

            if ($bookingModel->createBooking($data)) {
                header('Location: ./index.php?page=booking&success=Booking request submitted successfully');
                exit;
            } else {
                throw new \Exception("Failed to create booking");
            }
        } catch (\Exception $e) {
            error_log("Error in BookingController::store: " . $e->getMessage());
            header('Location: ./index.php?page=booking&error=' . urlencode($e->getMessage()));
            exit;
        }
    }
}

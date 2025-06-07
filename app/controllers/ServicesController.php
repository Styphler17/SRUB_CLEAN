<?php

namespace App\Controllers;

use App\Models\Service;

class ServicesController extends Controller
{
    private $serviceModel;

    public function __construct()
    {
        try {
            $this->serviceModel = new Service();
        } catch (\Exception $e) {
            // Log the error and show a user-friendly message
            error_log("Error in ServicesController: " . $e->getMessage());
            die("An error occurred while loading the services. Please try again later.");
        }
    }

    public function index()
    {
        try {
            $services = $this->serviceModel->getActiveServices();
            if (empty($services)) {
                // If no services found, show a message
                $services = [];
            }
            $this->render('services/index', ['services' => $services]);
        } catch (\Exception $e) {
            // Log the error and show a user-friendly message
            error_log("Error in ServicesController::index: " . $e->getMessage());
            die("An error occurred while loading the services. Please try again later.");
        }
    }
}

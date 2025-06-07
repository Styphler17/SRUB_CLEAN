<?php

namespace App\Controllers;

use App\Models\Service;
use App\Models\Review;

class HomeController extends Controller
{
    public function index()
    {
        $serviceModel = new Service();
        $services = $serviceModel->getActiveServices();

        // Get testimonials (reviews) for the home page
        $reviewModel = new Review();
        $testimonials = $reviewModel->getLatestReviews(3); // Get 3 latest reviews

        $this->render('pages/home', [
            'services' => $services,
            'testimonials' => $testimonials
        ]);
    }
}

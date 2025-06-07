<?php

namespace App\Controllers;

use App\Models\Review;

class TestimonialsController extends Controller
{
    public function index()
    {
        $reviewModel = new Review();
        $reviews = $reviewModel->getAllReviews();

        $this->render('testimonials/index', [
            'reviews' => $reviews
        ]);
    }

    public function submit()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ./index.php?page=testimonials');
            exit;
        }

        $name = trim($_POST['name'] ?? '');
        $rating = intval($_POST['rating'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        $errors = [];

        if (empty($name)) {
            $errors['name'] = 'Name is required.';
        }
        if ($rating < 1 || $rating > 5) {
            $errors['rating'] = 'Rating must be between 1 and 5.';
        }
        if (empty($comment)) {
            $errors['comment'] = 'Comment is required.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['form_data'] = [
                'name' => $name,
                'rating' => $rating,
                'comment' => $comment
            ];
            header('Location: ./index.php?page=testimonials');
            exit;
        }

        $reviewModel = new \App\Models\Review();
        $success = $reviewModel->createReview([
            'name' => $name,
            'rating' => $rating,
            'comment' => $comment
        ]);

        if ($success) {
            $_SESSION['success'] = 'Thank you for your review!';
        } else {
            $_SESSION['errors']['general'] = 'Failed to submit your review. Please try again later.';
        }
        header('Location: ./index.php?page=testimonials');
        exit;
    }
}

<?php

namespace App\Controllers;

class PageController extends Controller
{
    public function about()
    {
        $this->render('about/index');
    }

    public function process()
    {
        $this->render('process/index');
    }

    public function contact()
    {
        // Only render the contact page, no CSRF or form logic
        $this->render('contact/index');
    }
}

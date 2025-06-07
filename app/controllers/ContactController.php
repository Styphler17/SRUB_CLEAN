<?php

namespace App\Controllers;

use App\Models\ContactInfo;
use App\Models\BusinessHours;

class ContactController extends Controller
{
    public function index()
    {
        $contactModel = new ContactInfo();
        $contactInfo = $contactModel->getInfo();
        $hoursModel = new BusinessHours();
        $businessHours = $hoursModel->getAll();
        $this->render('components/_contact', [
            'contactInfo' => $contactInfo,
            'businessHours' => $businessHours
        ]);
    }
}

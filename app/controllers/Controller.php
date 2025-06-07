<?php

namespace App\Controllers;

abstract class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);
        ob_start();
        require_once __DIR__ . "/../../app/views/{$view}.php";
        $content = ob_get_clean();
        require_once __DIR__ . "/../../app/views/templates/index.php";
    }
}

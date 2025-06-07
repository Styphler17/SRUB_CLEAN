<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Remove 'public' from the path if it exists
$uri = str_replace('public/', '', $uri);
$uri = trim($uri, '/');

// If we're at the root of public directory, show home page
if (empty($uri)) {
    $uri = 'home';
}

// Get query parameters
if (isset($_GET['page'])) {
    $uri = $_GET['page'];
}

global $connexion;

try {
    switch ($uri) {
        case '':
        case 'index.php':
        case 'home':
            $controller = "App\\Controllers\\HomeController";
            $method = 'index';
            break;
        case 'booking':
            $controller = "App\\Controllers\\BookingController";
            $method = 'index';
            break;
        case 'booking/store':
            $controller = "App\\Controllers\\BookingController";
            $method = 'store';
            break;
        case 'services':
            $controller = "App\\Controllers\\ServicesController";
            $method = 'index';
            break;
        case 'testimonials':
            $controller = "App\\Controllers\\TestimonialsController";
            $method = 'index';
            break;
        case 'testimonials/submit':
            $controller = "App\\Controllers\\TestimonialsController";
            $method = 'submit';
            break;
        case 'about':
            $controller = "App\\Controllers\\PageController";
            $method = 'about';
            break;
        case 'process':
            $controller = "App\\Controllers\\PageController";
            $method = 'process';
            break;
        case 'contact':
            $controller = "App\\Controllers\\PageController";
            $method = 'contact';
            break;
        case 'contact/send':
            $controller = "App\\Controllers\\PageController";
            $method = 'sendContact';
            break;
        case 'terms':
            require_once __DIR__ . '/../views/terms.php';
            exit;
        case 'privacy':
            require_once __DIR__ . '/../views/privacy.php';
            exit;
        default:
            header("HTTP/1.0 404 Not Found");
            require_once __DIR__ . '/../views/errors/404.php';
            exit;
    }

    $controllerInstance = new $controller();
    $controllerInstance->$method();
} catch (\Exception $e) {
    error_log("Error in router: " . $e->getMessage());
    echo "<pre>Error: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "</pre>";
    header("HTTP/1.0 500 Internal Server Error");
    require_once __DIR__ . '/../views/errors/500.php';
}

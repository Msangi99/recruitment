<?php

use Illuminate\Http\Request;

if (! function_exists('highlight_file')) {
    function highlight_file($filename, $return = false)
    {
        if (! file_exists($filename)) {
            return false;
        }
        
        $content = file_get_contents($filename);
        $highlighted = '<code style="background-color: #f8f9fa; padding: 15px; display: block; overflow-x: auto; font-family: monospace;">' . htmlspecialchars($content) . '</code>';
        
        if ($return) {
            return $highlighted;
        }
        
        echo $highlighted;
        return true;
    }
}

define('LARAVEL_START', microtime(true));

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());

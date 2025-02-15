<?php
function customErrorHandler($errno, $errstr, $errfile, $errline) {
    $logFile = __DIR__ . '/../logs/error.log';
    $message = date('[Y-m-d H:i:s]') . " Error: [$errno] $errstr in $errfile on line $errline\n";
    error_log($message, 3, $logFile);
    
    if (ini_get('display_errors')) {
        echo "<div class='alert alert-danger'>Une erreur est survenue. Veuillez réessayer plus tard.</div>";
    }
    return true;
}

set_error_handler('customErrorHandler'); 
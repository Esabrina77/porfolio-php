<?php
function render($view, $data = [], $layout = 'layout') {
    // Extraire les variables du tableau $data
    extract($data);
    
    // Démarrer la temporisation de sortie
    ob_start();
    
    // Inclure la vue
    require __DIR__ . "/../views/{$view}.php";
    
    // Récupérer le contenu
    $content = ob_get_clean();
    
    // Définir le chemin de base pour les includes
    define('VIEW_PATH', __DIR__ . '/../views/');
    
    // Inclure le layout avec le contenu
    require VIEW_PATH . "{$layout}.php";
} 
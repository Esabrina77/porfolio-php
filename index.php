<?php
session_start();


require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/ProjectController.php';
require_once __DIR__ . '/controllers/SkillController.php';

require_once 'config/database.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Routes basiques
switch ($uri) {
    case '':
    case 'projects':
        $controller = new ProjectController();
        $projects = $controller->index();
        require 'views/projects/index.php';
        break;

    case 'projects/create':
        $controller = new ProjectController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->create();
            if (isset($result['success'])) {
                header('Location: /projects');
                exit;
            }
            $error = $result['error'] ?? null;
        }
        require 'views/projects/form.php';
        break;

    case 'login':
        $controller = new UserController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->login();
            if (isset($result['success'])) {
                header('Location: /profile');
                exit;
            }
            $error = $result['error'] ?? null;
        }
        require 'views/auth/login.php';
        break;

    case 'profile':
        $controller = new UserController();
        $user = $controller->profile();
        $projectController = new ProjectController();
        $userProjects = $projectController->getUserProjects();
        $skillController = new SkillController();
        $userSkills = $skillController->getUserSkills();
        require 'views/users/profile.php';
        break;

    default:
        http_response_code(404);
        echo "Page non trouvée";
        break;
} 
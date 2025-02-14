<?php
session_start();

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/ProjectController.php';
require_once __DIR__ . '/controllers/SkillController.php';
require_once 'controllers/AuthController.php';
require_once 'config/database.php';
require_once 'controllers/AdminSkillController.php';
require_once 'controllers/AdminProjectController.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = trim($uri, '/');

// Routes basiques
switch ($uri) {
    case '':
        if (isset($_SESSION['user'])) {
            header('Location: /profile');
            exit;
        }
        render('home');
        break;

    case 'projects':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $projectController = new ProjectController();
        $projectData = $projectController->index();
        render('projects/index', $projectData);
        break;

    case 'projects/create':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $projectController = new ProjectController();
        $projectController->create();
        break;

    case 'register':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->register();
            if (isset($result['success'])) {
                header('Location: /login');
                exit;
            }
            $error = $result['error'] ?? null;
        }
        render('auth/register', ['error' => $error ?? null]);
        break;

    case 'login':
        $controller = new AuthController();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $controller->login();
            if (isset($result['success'])) {
                header('Location: /profile');
                exit;
            }
            $error = $result['error'] ?? null;
        }
        render('auth/login', ['error' => $error ?? null]);
        break;

    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'profile':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $userController = new UserController();
        $userData = $userController->profile();
        render('users/profile', $userData);
        break;

    case 'admin/profiles':
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $userController = new UserController();
        $users = $userController->allProfiles();
        render('admin/profiles', ['users' => $users]);
        break;

    case 'admin/dashboard':
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        render('admin/dashboard', [], 'admin/layout');
        break;

    case 'skills':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $skillController = new SkillController();
        $skillData = $skillController->index();
        render('skills/index', $skillData);
        break;

    case 'skills/add':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $skillController = new SkillController();
        $skillController->addUserSkill();
        break;

    case 'skills/remove':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $skillController = new SkillController();
        $skillController->removeUserSkill();
        break;

    // Routes admin
    case 'admin/skills':
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminSkillController = new AdminSkillController();
        $skillData = $adminSkillController->index();
        render('admin/skills', $skillData, 'admin/layout');
        break;

    case 'admin/skills/create':
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminSkillController = new AdminSkillController();
        $adminSkillController->create();
        break;

    case (preg_match('/^admin\/skills\/delete\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminSkillController = new AdminSkillController();
        $adminSkillController->delete($matches[1]);
        break;

    case (preg_match('/^admin\/skills\/edit\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminSkillController = new AdminSkillController();
        $skillData = $adminSkillController->edit($matches[1]);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            render('admin/skills', $skillData, 'admin/layout');
        }
        break;

    case 'admin/projects':
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminProjectController = new AdminProjectController();
        $projectData = $adminProjectController->index();
        render('admin/projects', $projectData, 'admin/layout');
        break;

    case (preg_match('/^admin\/projects\/delete\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminProjectController = new AdminProjectController();
        $adminProjectController->delete($matches[1]);
        break;

    case (preg_match('/^admin\/projects\/edit\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        $adminProjectController = new AdminProjectController();
        $projectData = $adminProjectController->edit($matches[1]);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            render('admin/projects', $projectData, 'admin/layout');
        }
        break;

    case 'profile/edit':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $userController = new UserController();
        $userController->edit();
        break;

    case 'profile/update':
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $userController = new UserController();
        $userController->update();
        break;

    // Routes pour les projets
    case (preg_match('/^projects\/edit\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $projectController = new ProjectController();
        $projectData = $projectController->edit($matches[1]);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            render('projects/form', $projectData);
        }
        break;

    case (preg_match('/^projects\/update\/(\d+)$/', $uri, $matches) ? true : false):
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        $projectController = new ProjectController();
        $projectController->update($matches[1]);
        break;

    default:
        http_response_code(404);
        render('errors/404');
        break;
} 
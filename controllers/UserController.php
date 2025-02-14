<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Skill.php';
require_once __DIR__ . '/../models/Project.php';

class UserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            if (!$email) {
                return ['error' => 'Email invalide'];
            }
            if (strlen($password) < 6) {
                return ['error' => 'Le mot de passe doit faire au moins 6 caractères'];
            }
            if ($password !== $confirmPassword) {
                return ['error' => 'Les mots de passe ne correspondent pas'];
            }

            if ($this->userModel->register($email, $password)) {
                return ['success' => 'Compte créé avec succès'];
            }
            return ['error' => 'Erreur lors de la création du compte'];
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                return ['error' => 'Email ou mot de passe manquant'];
            }

            $user = $this->userModel->login($email, $password);
            if ($user) {
                session_start();
                $_SESSION['user'] = $user;
                return ['success' => 'Connexion réussie'];
            }
            return ['error' => 'Email ou mot de passe incorrect'];
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        
        $user = [
            'id' => $_SESSION['user']['id'],
            'email' => $_SESSION['user']['email'],
            'is_admin' => $_SESSION['user']['is_admin'],
            'created_at' => date('Y-m-d H:i:s') // Si pas dans la session, utilisez la date actuelle
        ];
        
        // Récupérer les compétences et projets
        $skillModel = new Skill();
        $projectModel = new Project();
        
        return [
            'user' => $user,
            'userSkills' => $skillModel->getUserSkills($user['id']) ?? [],
            'userProjects' => $projectModel->getUserProjects($user['id']) ?? []
        ];
    }

    public function allProfiles() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }
        
        $userModel = new User();
        return $userModel->getAllUsers();
    }

    public function edit() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->getUserById($_SESSION['user']['id']);
        render('users/edit', ['user' => $user]);
    }

    public function update() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId = $_SESSION['user']['id'];
            $currentPassword = $_POST['current_password'] ?? '';
            
            if (!$this->userModel->verifyPassword($userId, $currentPassword)) {
                $_SESSION['error'] = "Mot de passe actuel incorrect";
                header('Location: /profile/edit');
                exit;
            }

            $data = [
                'email' => $_POST['email'],
                'firstname' => $_POST['firstname'],
                'lastname' => $_POST['lastname'],
                'bio' => $_POST['bio']
            ];

            if (!empty($_POST['new_password'])) {
                $data['password'] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            }

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
                $uploadDir = 'public/uploads/avatars/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $avatarPath = 'uploads/avatars/' . uniqid() . '_' . $_FILES['avatar']['name'];
                move_uploaded_file($_FILES['avatar']['tmp_name'], 'public/' . $avatarPath);
                $data['avatar_path'] = $avatarPath;
            }

            $this->userModel->updateUser($userId, $data);
            $_SESSION['success'] = "Profil mis à jour avec succès";
            header('Location: /profile');
            exit;
        }
    }
} 
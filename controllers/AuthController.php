<?php
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if (!$email) {
                return ['error' => 'Email invalide'];
            }
            if (strlen($password) < 6) {
                return ['error' => 'Le mot de passe doit faire au moins 6 caractères'];
            }
            if ($password !== $confirmPassword) {
                return ['error' => 'Les mots de passe ne correspondent pas'];
            }

            // Vérifier si c'est un compte admin
            $isAdmin = ($email === 'admin@example.com');

            // Tentative d'inscription
            if ($this->userModel->register($email, $password, $isAdmin)) {
                return ['success' => 'Compte créé avec succès'];
            }
            return ['error' => 'Cet email est déjà utilisé'];
        }
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || !$password) {
                return ['error' => 'Email ou mot de passe invalide'];
            }

            $user = $this->userModel->login($email, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                // Redirection différente selon le rôle
                if ($user['is_admin']) {
                    header('Location: /admin/dashboard');
                } else {
                    header('Location: /profile');
                }
                exit;
            }
            return ['error' => 'Email ou mot de passe incorrect'];
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        setcookie('remember_token', '', time() - 3600, '/');
        header('Location: /login');
        exit;
    }
}

<?php
require_once 'models/User.php';

class AdminUserController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function edit($id) {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        $user = $this->userModel->getUserById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $is_admin = isset($_POST['is_admin']) ? 1 : 0;
            $password = $_POST['password'] ?? '';

            if ($email) {
                $data = [
                    'email' => $email,
                    'is_admin' => $is_admin
                ];

                if ($password) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $this->userModel->updateUser($id, $data);
                header('Location: /admin/profiles');
                exit;
            }
        }

        return ['user' => $user];
    }
} 
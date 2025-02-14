<?php
require_once __DIR__ . '/../models/Project.php';
require_once __DIR__ . '/../models/User.php';

class AdminProjectController {
    private $projectModel;
    private $userModel;

    public function __construct() {
        $this->projectModel = new Project();
        $this->userModel = new User();
    }

    public function index() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        return [
            'projects' => $this->projectModel->getAllProjects(),
            'users' => $this->userModel->getAllUsers()
        ];
    }

    public function delete($id) {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        $project = $this->projectModel->getProject($id);
        if ($project && $project['image_path']) {
            unlink('public/' . $project['image_path']);
        }

        $this->projectModel->deleteProject($id, $project['user_id']);
        header('Location: /admin/projects');
        exit;
    }

    public function edit($id) {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        $project = $this->projectModel->getProject($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $external_link = $_POST['external_link'] ?? '';

            if ($title) {
                $image_path = $project['image_path'];
                
                if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                    if ($project['image_path']) {
                        unlink('public/' . $project['image_path']);
                    }
                    
                    $upload_dir = 'public/uploads/projects/';
                    if (!file_exists($upload_dir)) {
                        mkdir($upload_dir, 0777, true);
                    }
                    
                    $image_path = 'uploads/projects/' . uniqid() . '_' . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], 'public/' . $image_path);
                }

                $this->projectModel->updateProject($id, $title, $description, $image_path, $external_link);
                header('Location: /admin/projects');
                exit;
            }
        }

        return [
            'project' => $project,
            'users' => $this->userModel->getAllUsers()
        ];
    }
} 
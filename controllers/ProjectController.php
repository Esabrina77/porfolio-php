<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $projectModel;

    public function __construct() {
        $this->projectModel = new Project();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }
        
        return [
            'projects' => $this->projectModel->getUserProjects($_SESSION['user']['id'])
        ];
    }

    public function create() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $externalLink = $_POST['external_link'] ?? '';
            $imagePath = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $uploadDir = 'public/uploads/projects/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileName = uniqid() . '_' . $_FILES['image']['name'];
                $imagePath = 'uploads/projects/' . $fileName;
                $fullPath = 'public/' . $imagePath;
                
                if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
                    chmod($fullPath, 0644);
                }
            }

            $this->projectModel->create(
                $_SESSION['user']['id'],
                $title,
                $description,
                $imagePath,
                $externalLink
            );

            header('Location: /projects');
            exit;
        }

        render('projects/form');
    }

    public function update($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $project = $this->projectModel->getProject($id);
        if (!$project || $project['user_id'] !== $_SESSION['user']['id']) {
            header('Location: /projects');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $description = $_POST['description'] ?? '';
        $externalLink = $_POST['external_link'] ?? '';
        $imagePath = $project['image_path'];

        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            if ($project['image_path'] && file_exists('public/' . $project['image_path'])) {
                unlink('public/' . $project['image_path']);
            }
            
            $fileName = uniqid() . '_' . $_FILES['image']['name'];
            $imagePath = 'uploads/projects/' . $fileName;
            $fullPath = 'public/' . $imagePath;
            
            if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
                chmod($fullPath, 0644);
            }
        }

        $this->projectModel->update($id, $title, $description, $imagePath, $externalLink);
        header('Location: /projects');
        exit;
    }

    public function delete($id) {
        session_start();
        if (!isset($_SESSION['user'])) {
            return ['error' => 'Utilisateur non connecté'];
        }

        $project = $this->projectModel->getById($id);
        if (!$project) {
            return ['error' => 'Projet non trouvé'];
        }

        // Supprimer l'image si elle existe
        if ($project['image_path']) {
            $imagePath = __DIR__ . '/../public/' . $project['image_path'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        if ($this->projectModel->delete($id)) {
            return ['success' => 'Projet supprimé avec succès'];
        }
        return ['error' => 'Erreur lors de la suppression'];
    }

    public function getUserProjects($userId = null) {
        session_start();
        if (!isset($_SESSION['user'])) {
            return [];
        }
        $userId = $userId ?? $_SESSION['user']['id'];
        return $this->projectModel->getUserProjects($userId);
    }

    public function edit($id) {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $project = $this->projectModel->getProject($id);
        
        if (!$project || $project['user_id'] !== $_SESSION['user']['id']) {
            header('Location: /projects');
            exit;
        }

        return ['project' => $project];
    }
}

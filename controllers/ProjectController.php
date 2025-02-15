<?php
require_once __DIR__ . '/../models/Project.php';

class ProjectController {
    private $projectModel;
    private $db;

    public function __construct() {
        $this->projectModel = new Project();
        $this->db = Database::getInstance()->getConnection();
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT p.*, u.email as user_email 
                FROM projects p 
                LEFT JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC 
                LIMIT :limit OFFSET :offset";
                
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $projects = $stmt->fetchAll();

        // Compte total pour la pagination
        $totalSql = "SELECT COUNT(*) FROM projects";
        $total = $this->db->query($totalSql)->fetchColumn();
        $pages = ceil($total / $limit);

        return [
            'projects' => $projects,
            'currentPage' => $page,
            'totalPages' => $pages,
            'limit' => $limit
        ];
    }

    public function create() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once __DIR__ . '/../includes/csrf.php';
            if (!validateCsrfToken($_POST['csrf_token'] ?? '')) {
                die('Token CSRF invalide');
            }
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

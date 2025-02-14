<?php
require_once __DIR__ . '/../models/Skill.php';

class AdminSkillController {
    private $skillModel;

    public function __construct() {
        $this->skillModel = new Skill();
    }

    public function index() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        return [
            'skills' => $this->skillModel->getAllSkills(),
            'skillModel' => $this->skillModel
        ];
    }

    public function create() {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if ($name) {
                $this->skillModel->addSkill($name, $description);
                header('Location: /admin/skills');
                exit;
            }
        }
    }

    public function delete($id) {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        $this->skillModel->deleteSkill($id);
        header('Location: /admin/skills');
        exit;
    }

    public function edit($id) {
        if (!isset($_SESSION['user']) || !$_SESSION['user']['is_admin']) {
            header('Location: /login');
            exit;
        }

        $skill = $this->skillModel->getSkillById($id);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $description = $_POST['description'] ?? '';

            if ($name) {
                $this->skillModel->updateSkill($id, $name, $description);
                header('Location: /admin/skills');
                exit;
            }
        }

        return ['skill' => $skill];
    }
} 
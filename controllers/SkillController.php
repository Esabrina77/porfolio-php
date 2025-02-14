<?php
require_once __DIR__ . '/../models/Skill.php';

class SkillController {
    private $skillModel;

    public function __construct() {
        $this->skillModel = new Skill();
    }

    public function index() {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $skills = $this->skillModel->getAllSkills();
        $userSkills = $this->skillModel->getUserSkills($_SESSION['user']['id']);
        
        return [
            'skills' => $skills,
            'userSkills' => $userSkills
        ];
    }

    public function addUserSkill() {
        if (!isset($_SESSION['user']) || !isset($_POST['skill_id']) || !isset($_POST['level'])) {
            header('Location: /skills');
            exit;
        }

        $this->skillModel->addUserSkill(
            $_SESSION['user']['id'],
            $_POST['skill_id'],
            $_POST['level']
        );

        header('Location: /skills');
    }

    public function removeUserSkill() {
        if (!isset($_SESSION['user']) || !isset($_POST['skill_id'])) {
            header('Location: /skills');
            exit;
        }

        $this->skillModel->removeUserSkill(
            $_SESSION['user']['id'],
            $_POST['skill_id']
        );

        header('Location: /skills');
        exit;
    }
}

<?php $title = 'Gestion des Compétences'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Compétences</h1>
        <a href="/admin/dashboard" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour au Dashboard
        </a>
    </div>

    <!-- Formulaire d'ajout -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Ajouter une compétence</h5>
        </div>
        <div class="card-body">
            <form action="/admin/skills/create" method="POST" class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">Nom de la compétence</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col-md-6">
                    <label for="description" class="form-label">Description</label>
                    <input type="text" class="form-control" id="description" name="description">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Ajouter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Liste des compétences -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Compétences existantes</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Utilisateurs</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($skills as $skill): ?>
                            <tr>
                                <td><?= htmlspecialchars($skill['id']) ?></td>
                                <td><?= htmlspecialchars($skill['name']) ?></td>
                                <td><?= htmlspecialchars($skill['description'] ?? '') ?></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-info" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#usersModal<?= $skill['id'] ?>">
                                        Voir les utilisateurs
                                    </button>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal<?= $skill['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete(<?= $skill['id'] ?>)">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php foreach ($skills as $skill): ?>
    <!-- Modal d'édition -->
    <div class="modal fade" id="editModal<?= $skill['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier la compétence</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/skills/edit/<?= $skill['id'] ?>" method="POST">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name<?= $skill['id'] ?>" class="form-label">Nom</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="name<?= $skill['id'] ?>" 
                                   name="name" 
                                   value="<?= htmlspecialchars($skill['name']) ?>" 
                                   required>
                        </div>
                        <div class="mb-3">
                            <label for="description<?= $skill['id'] ?>" class="form-label">Description</label>
                            <textarea class="form-control" 
                                      id="description<?= $skill['id'] ?>" 
                                      name="description" 
                                      rows="3"><?= htmlspecialchars($skill['description'] ?? '') ?></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal des utilisateurs -->
    <div class="modal fade" id="usersModal<?= $skill['id'] ?>" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Utilisateurs - <?= htmlspecialchars($skill['name']) ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <?php 
                    $skillUsers = $skillModel->getSkillUsers($skill['id']);
                    if (!empty($skillUsers)): 
                    ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Email</th>
                                        <th>Niveau</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($skillUsers as $user): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($user['email']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= getLevelBadgeClass($user['level']) ?>">
                                                    <?= htmlspecialchars($user['level']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted mb-0">Aucun utilisateur n'a cette compétence.</p>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php
function getLevelBadgeClass($level) {
    switch ($level) {
        case 'débutant':
            return 'warning';
        case 'intermédiaire':
            return 'info';
        case 'expert':
            return 'success';
        default:
            return 'secondary';
    }
}
?>

<script>
function confirmDelete(skillId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette compétence ?')) {
        window.location.href = `/admin/skills/delete/${skillId}`;
    }
}
</script> 
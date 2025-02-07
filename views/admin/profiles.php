<?php $title = 'Gestion des Utilisateurs'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Utilisateurs</h1>
        <a href="/admin/dashboard" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour au Dashboard
        </a>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert alert-success">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Date d'inscription</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['id']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <span class="badge <?= $user['is_admin'] ? 'bg-primary' : 'bg-secondary' ?>">
                                        <?= $user['is_admin'] ? 'Admin' : 'Utilisateur' ?>
                                    </span>
                                </td>
                                <td><?= (new DateTime($user['created_at']))->format('d/m/Y H:i') ?></td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/users/edit/<?= $user['id'] ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($user['id'] !== $_SESSION['user']['id']): ?>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    onclick="confirmDelete(<?= $user['id'] ?>)">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        <?php endif; ?>
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

<script>
function confirmDelete(userId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        window.location.href = `/admin/users/delete/${userId}`;
    }
}
</script> 
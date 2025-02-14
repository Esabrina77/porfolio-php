<?php $title = 'Gestion des Projets'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Gestion des Projets</h1>
        <a href="/admin/dashboard" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Retour au Dashboard
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="card-title mb-0">Tous les projets</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Utilisateur</th>
                            <th>Titre</th>
                            <th>Image</th>
                            <th>Lien</th>
                            <th>Date création</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td><?= $project['id'] ?></td>
                                <td><?= htmlspecialchars($project['user_email']) ?></td>
                                <td><?= htmlspecialchars($project['title']) ?></td>
                                <td>
                                    <?php if ($project['image_path']): ?>
                                        <img src="/<?= htmlspecialchars($project['image_path']) ?>" 
                                             alt="Aperçu" 
                                             class="img-thumbnail" 
                                             style="max-width: 50px">
                                    <?php else: ?>
                                        <span class="text-muted">Aucune image</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($project['external_link']): ?>
                                        <a href="<?= htmlspecialchars($project['external_link']) ?>" 
                                           target="_blank" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-link-45deg"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($project['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-primary"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#editModal<?= $project['id'] ?>">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete(<?= $project['id'] ?>)">
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

<!-- Modals d'édition -->
<?php foreach ($projects as $project): ?>
    <div class="modal fade" id="editModal<?= $project['id'] ?>" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modifier le projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="/admin/projects/edit/<?= $project['id'] ?>" 
                      method="POST" 
                      enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Titre</label>
                            <input type="text" 
                                   class="form-control" 
                                   name="title" 
                                   value="<?= htmlspecialchars($project['title']) ?>" 
                                   required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" 
                                      name="description" 
                                      rows="3"><?= htmlspecialchars($project['description']) ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Image</label>
                            <?php if ($project['image_path']): ?>
                                <div class="mb-2">
                                    <img src="/<?= htmlspecialchars($project['image_path']) ?>" 
                                         class="img-thumbnail" 
                                         style="max-width: 200px">
                                </div>
                            <?php endif; ?>
                            <input type="file" 
                                   class="form-control" 
                                   name="image" 
                                   accept="image/*">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lien externe</label>
                            <input type="url" 
                                   class="form-control" 
                                   name="external_link" 
                                   value="<?= htmlspecialchars($project['external_link'] ?? '') ?>">
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
<?php endforeach; ?>

<script>
function confirmDelete(projectId) {
    if (confirm('Êtes-vous sûr de vouloir supprimer ce projet ?')) {
        window.location.href = `/admin/projects/delete/${projectId}`;
    }
}
</script> 
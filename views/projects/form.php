<?php $title = isset($project) ? 'Modifier le projet' : 'Nouveau projet'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $title ?></h2>
            </div>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="title" name="title" 
                               value="<?= isset($project) ? htmlspecialchars($project['title']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?= isset($project) ? htmlspecialchars($project['description']) : '' ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <?php if (isset($project) && $project['image_path']): ?>
                            <div class="mb-2">
                                <img src="/<?= htmlspecialchars($project['image_path']) ?>" alt="Image actuelle" style="max-width: 200px;">
                            </div>
                        <?php endif; ?>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="external_link" class="form-label">Lien externe</label>
                        <input type="url" class="form-control" id="external_link" name="external_link" 
                               value="<?= isset($project) ? htmlspecialchars($project['external_link']) : '' ?>">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= isset($project) ? 'Mettre à jour' : 'Créer' ?>
                        </button>
                        <a href="/projects" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<?php $title = isset($project) ? 'Modifier le projet' : 'Nouveau projet'; ?>

<style>
.project-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.project-form .card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 12px;
    background: white;
}

.project-form .card-header {
    background: #007bff;
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 1.5rem;
}

.project-form .card-body {
    padding: 2rem;
}

.project-form .form-label {
    font-weight: 500;
    color: #333;
    font-size: 1rem;
    margin-bottom: 0.75rem;
}

.project-form .form-control {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 0.75rem;
    margin-bottom: 1rem;
}

.project-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
}

.project-preview {
    max-width: 300px;
    margin: 1rem 0;
}

.project-preview img {
    width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.project-actions {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 6px;
    font-weight: 500;
}

.btn-primary {
    background: #007bff;
    border: none;
}

.btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
}
</style>

<div class="container project-form">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0"><?= $title ?></h2>
        </div>
        <div class="card-body">
            <form action="<?= isset($project) ? '/projects/update/'.$project['id'] : '/projects/create' ?>" 
                  method="POST" 
                  enctype="multipart/form-data">
                
                <div class="mb-3">
                    <label for="title" class="form-label">Titre du projet</label>
                    <input type="text" 
                           class="form-control" 
                           id="title" 
                           name="title" 
                           value="<?= isset($project) ? htmlspecialchars($project['title']) : '' ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" 
                              id="description" 
                              name="description" 
                              rows="5" 
                              required><?= isset($project) ? htmlspecialchars($project['description']) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Image du projet</label>
                    <?php if (isset($project) && $project['image_path']): ?>
                        <div class="project-preview">
                            <img src="/public/<?= htmlspecialchars($project['image_path']) ?>" 
                                 alt="Image actuelle" 
                                 class="img-thumbnail">
                        </div>
                    <?php endif; ?>
                    <div class="custom-file-upload">
                        <input type="file" 
                               class="form-control" 
                               id="image" 
                               name="image" 
                               accept="image/*">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="external_link" class="form-label">Lien externe</label>
                    <input type="url" 
                           class="form-control" 
                           id="external_link" 
                           name="external_link" 
                           value="<?= isset($project) ? htmlspecialchars($project['external_link']) : '' ?>">
                </div>

                <div class="project-actions">
                    <button type="submit" class="btn btn-primary">
                        <?= isset($project) ? 'Mettre à jour' : 'Créer le projet' ?>
                    </button>
                    <a href="/projects" class="btn btn-outline-secondary">Annuler</a>
                </div>
            </form>
        </div>
    </div>
</div> 
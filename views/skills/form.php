<?php $title = isset($skill) ? 'Modifier la compétence' : 'Nouvelle compétence'; ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><?= $title ?></h2>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?= isset($skill) ? htmlspecialchars($skill['name']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?= isset($skill) ? htmlspecialchars($skill['description']) : '' ?></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">
                            <?= isset($skill) ? 'Mettre à jour' : 'Créer' ?>
                        </button>
                        <a href="/skills" class="btn btn-outline-secondary">Annuler</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 
<?php $title = 'Compétences'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Compétences</h1>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
        <a href="/skills/create" class="btn btn-primary">Nouvelle Compétence</a>
    <?php endif; ?>
</div>

<div class="row">
    <?php foreach ($skills as $skill): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($skill['name']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($skill['description']) ?></p>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <form action="/skills/add-user-skill" method="POST" class="mt-3">
                            <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                            <div class="mb-2">
                                <select name="level" class="form-select" required>
                                    <option value="">Choisir un niveau</option>
                                    <option value="débutant">Débutant</option>
                                    <option value="intermédiaire">Intermédiaire</option>
                                    <option value="expert">Expert</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">Ajouter à mon profil</button>
                        </form>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['is_admin']): ?>
                        <div class="mt-3">
                            <a href="/skills/edit/<?= $skill['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="/skills/delete/<?= $skill['id'] ?>" method="POST" class="d-inline">
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                            </form>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div> 
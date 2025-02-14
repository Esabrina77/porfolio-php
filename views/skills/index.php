<?php $title = 'Mes Compétences'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Gérer mes compétences</h1>
        </div>
    </div>

    <!-- Liste des compétences actuelles -->
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Mes compétences actuelles</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($userSkills)): ?>
                        <div class="row g-3">
                            <?php foreach ($userSkills as $skill): ?>
                                <div class="col-md-4">
                                    <div class="skill-item p-3 bg-light rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h5 class="mb-1"><?= htmlspecialchars($skill['name']) ?></h5>
                                            <span class="badge bg-primary"><?= htmlspecialchars($skill['level']) ?></span>
                                        </div>
                                        <form action="/skills/remove" method="POST" class="mt-2">
                                            <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Vous n'avez pas encore ajouté de compétences.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire d'ajout de compétence -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Ajouter une compétence</h3>
                </div>
                <div class="card-body">
                    <form action="/skills/add" method="POST">
                        <div class="mb-3">
                            <label for="skill" class="form-label">Compétence</label>
                            <select class="form-select" id="skill" name="skill_id" required>
                                <option value="">Choisir une compétence...</option>
                                <?php foreach ($skills as $skill): ?>
                                    <option value="<?= $skill['id'] ?>"><?= htmlspecialchars($skill['name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="level" class="form-label">Niveau</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="débutant">Débutant</option>
                                <option value="intermédiaire">Intermédiaire</option>
                                <option value="avancé">Avancé</option>
                                <option value="expert">Expert</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<?php $title = 'Profil'; ?>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h3>Informations</h3>
            </div>
            <div class="card-body">
                <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
                <p><strong>Membre depuis:</strong> <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                <?php if ($user['is_admin']): ?>
                    <span class="badge bg-primary">Administrateur</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h3>Mes Compétences</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($userSkills)): ?>
                    <div class="row">
                        <?php foreach ($userSkills as $skill): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($skill['name']) ?></h5>
                                        <p class="card-text">
                                            <span class="badge bg-info"><?= htmlspecialchars($skill['level']) ?></span>
                                        </p>
                                        <form action="/skills/remove-user-skill" method="POST" class="d-inline">
                                            <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Retirer</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Aucune compétence ajoutée pour le moment.</p>
                <?php endif; ?>
                <a href="/skills" class="btn btn-primary">Ajouter des compétences</a>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Mes Projets</h3>
            </div>
            <div class="card-body">
                <?php if (!empty($userProjects)): ?>
                    <div class="row">
                        <?php foreach ($userProjects as $project): ?>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <?php if ($project['image_path']): ?>
                                        <img src="/<?= htmlspecialchars($project['image_path']) ?>" class="card-img-top" alt="Image du projet">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                                        <a href="/projects/edit/<?= $project['id'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>Aucun projet créé pour le moment.</p>
                <?php endif; ?>
                <a href="/projects/create" class="btn btn-primary">Ajouter un projet</a>
            </div>
        </div>
    </div>
</div> 
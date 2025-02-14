<?php $title = 'Profil'; ?>

<div class="container">
    <!-- En-tête du profil avec gradient -->
    <div class="profile-header mb-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <img src="<?= file_exists('public/images/default-avatar.png') ? '/images/default-avatar.png' : 'https://via.placeholder.com/150' ?>" 
                         alt="Avatar" 
                         class="profile-avatar mb-3">
                </div>
                <div class="col-md-9">
                    <h2><?= htmlspecialchars($user['email'] ?? 'Utilisateur') ?></h2>
                    <p>Membre depuis: <?= isset($user['created_at']) ? date('d/m/Y', strtotime($user['created_at'])) : date('d/m/Y') ?></p>
                    <?php if (isset($user['is_admin']) && $user['is_admin']): ?>
                        <span class="badge bg-light text-primary">Administrateur</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Section Compétences -->
        <div class="col-md-6 mb-4">
            <div class="card skill-card h-100">
                <div class="card-header">
                    <h3 class="mb-0">Mes Compétences</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($userSkills)): ?>
                        <div class="row g-3">
                            <?php foreach ($userSkills as $skill): ?>
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                        <div>
                                            <h5 class="mb-1"><?= htmlspecialchars($skill['name']) ?></h5>
                                            <span class="skill-level level-<?= strtolower($skill['level']) ?>">
                                                <?= htmlspecialchars($skill['level']) ?>
                                            </span>
                                        </div>
                                        <form action="/skills/remove-user-skill" method="POST" class="d-inline">
                                            <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucune compétence ajoutée pour le moment.</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="/skills" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg"></i> Ajouter des compétences
                    </a>
                </div>
            </div>
        </div>

        <!-- Section Projets -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="mb-0">Mes Projets</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($userProjects)): ?>
                        <div class="project-grid">
                            <?php foreach ($userProjects as $project): ?>
                                <div class="card project-card">
                                    <?php if ($project['image_path']): ?>
                                        <img src="/<?= htmlspecialchars($project['image_path']) ?>" 
                                             class="project-image" 
                                             alt="<?= htmlspecialchars($project['title']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                                        <div class="project-actions">
                                            <a href="/projects/edit/<?= $project['id'] ?>" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Modifier
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Aucun projet créé pour le moment.</p>
                    <?php endif; ?>
                </div>
                <div class="card-footer">
                    <a href="/projects/create" class="btn btn-primary w-100">
                        <i class="bi bi-plus-lg"></i> Ajouter un projet
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> 
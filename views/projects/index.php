<?php $title = 'Mes Projets'; ?>

<?php if (!empty($projects)): ?>
    <!-- Debug: afficher le premier projet -->
    <pre><?php print_r($projects[0]); ?></pre>
<?php endif; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mes Projets</h1>
        <a href="/projects/create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau projet
        </a>
    </div>

    <div class="projects-grid">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="card project-card">
                    <?php if ($project['image_path']): ?>
                        <img src="/public/<?= htmlspecialchars($project['image_path']) ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($project['title']) ?>">
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                        <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                        <div class="btn-group">
                            <?php if ($project['external_link']): ?>
                                <a href="<?= htmlspecialchars($project['external_link']) ?>" 
                                   class="btn btn-outline-primary" 
                                   target="_blank">
                                    <i class="bi bi-link-45deg"></i> Voir le projet
                                </a>
                            <?php endif; ?>
                            <a href="/projects/edit/<?= $project['id'] ?>" 
                               class="btn btn-outline-secondary">
                                <i class="bi bi-pencil"></i> Modifier
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-muted">Vous n'avez pas encore de projets.</p>
        <?php endif; ?>
    </div>
</div> 
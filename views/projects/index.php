<?php $title = 'Projets'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Projets</h1>
    <?php if (isset($_SESSION['user'])): ?>
        <a href="/projects/create" class="btn btn-primary">Nouveau Projet</a>
    <?php endif; ?>
</div>

<div class="row">
    <?php foreach ($projects as $project): ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <?php if ($project['image_path']): ?>
                    <img src="/<?= htmlspecialchars($project['image_path']) ?>" class="card-img-top" alt="Image du projet">
                <?php endif; ?>
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                    <p class="card-text"><?= htmlspecialchars($project['description']) ?></p>
                    <?php if ($project['external_link']): ?>
                        <a href="<?= htmlspecialchars($project['external_link']) ?>" class="btn btn-outline-primary" target="_blank">Voir le projet</a>
                    <?php endif; ?>
                </div>
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['id'] === $project['user_id']): ?>
                    <div class="card-footer">
                        <a href="/projects/edit/<?= $project['id'] ?>" class="btn btn-sm btn-warning">Modifier</a>
                        <form action="/projects/delete/<?= $project['id'] ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr ?')">Supprimer</button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?> 
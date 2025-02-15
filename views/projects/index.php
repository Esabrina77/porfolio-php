<?php $title = 'Mes Projets'; ?>

<?php ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Mes Projets</h1>
        <a href="/projects/create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Nouveau projet
        </a>
    </div>

    <div class="search-container mb-4">
        <form method="GET" class="d-flex gap-2">
            <input type="text" 
                   name="search" 
                   class="form-control" 
                   placeholder="Rechercher un projet..."
                   value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
                   minlength="2">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>
    </div>

    <div class="search-filters mb-4">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Rechercher..." 
                       value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="skill" class="form-select">
                    <option value="">Toutes les compétences</option>
                    <?php foreach($skills as $skill): ?>
                        <option value="<?= $skill['id'] ?>" 
                                <?= isset($_GET['skill']) && $_GET['skill'] == $skill['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($skill['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>
        </form>
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

    <!-- Affichage des résultats -->
    <?php if (isset($searchResults)): ?>
        <div class="search-results">
            <?php if (empty($searchResults['projects']) && empty($searchResults['skills'])): ?>
                <div class="alert alert-info">Aucun résultat trouvé pour votre recherche.</div>
            <?php else: ?>
                <?php if (!empty($searchResults['projects'])): ?>
                    <h3>Projets trouvés</h3>
                    <div class="row">
                        <?php foreach ($searchResults['projects'] as $project): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <?php if ($project['image_path']): ?>
                                        <img src="<?= htmlspecialchars($project['image_path']) ?>" 
                                             class="card-img-top" 
                                             alt="<?= htmlspecialchars($project['title']) ?>">
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($project['title']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars(substr($project['description'], 0, 100)) ?>...</p>
                                        <a href="/projects/<?= $project['id'] ?>" class="btn btn-primary">Voir plus</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($searchResults['skills'])): ?>
                    <h3>Compétences trouvées</h3>
                    <div class="row">
                        <?php foreach ($searchResults['skills'] as $skill): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($skill['name']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($skill['description']) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav aria-label="Navigation des pages">
            <ul class="pagination justify-content-center">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Précédent</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= $i === $currentPage ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Suivant</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div> 
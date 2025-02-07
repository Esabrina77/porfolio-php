<?php $title = 'Accueil'; ?>

<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="display-4 mb-4">Bienvenue sur Portfolio Manager</h1>
            <p class="lead mb-4">
                Créez votre portfolio professionnel, gérez vos projets et mettez en avant vos compétences.
            </p>
            <div class="d-grid gap-3 d-sm-flex">
                <?php if (!isset($_SESSION['user'])): ?>
                    <a href="/register" class="btn btn-primary btn-lg px-4">Créer un compte</a>
                    <a href="/login" class="btn btn-outline-secondary btn-lg px-4">Se connecter</a>
                <?php else: ?>
                    <a href="/profile" class="btn btn-primary btn-lg px-4">Mon Profil</a>
                    <a href="/projects" class="btn btn-outline-secondary btn-lg px-4">Mes Projets</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body p-4">
                    <?php if (!isset($_SESSION['user'])): ?>
                        <h2 class="card-title mb-4">Connexion</h2>
                        <form method="POST" action="/login">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">Se souvenir de moi</label>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Se connecter</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <h2 class="card-title mb-4">Tableau de bord</h2>
                        <div class="list-group">
                            <a href="/profile" class="list-group-item list-group-item-action">
                                <i class="bi bi-person"></i> Mon Profil
                            </a>
                            <a href="/projects" class="list-group-item list-group-item-action">
                                <i class="bi bi-folder"></i> Mes Projets
                            </a>
                            <a href="/skills" class="list-group-item list-group-item-action">
                                <i class="bi bi-star"></i> Mes Compétences
                            </a>
                            <?php if ($_SESSION['user']['is_admin']): ?>
                                <a href="/admin" class="list-group-item list-group-item-action text-primary">
                                    <i class="bi bi-gear"></i> Administration
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ajout des icônes Bootstrap -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

<!-- Style personnalisé -->
<style>
.display-4 {
    font-weight: 600;
    color: #2c3e50;
}
.lead {
    color: #34495e;
}
.card {
    border: none;
    border-radius: 15px;
}
.list-group-item {
    border: none;
    padding: 12px 20px;
    margin-bottom: 5px;
    border-radius: 8px !important;
}
.list-group-item:hover {
    background-color: #f8f9fa;
}
.bi {
    margin-right: 10px;
}
</style> 
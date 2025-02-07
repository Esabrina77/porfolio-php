<?php $title = 'Dashboard Admin'; ?>

<div class="container">
    <div class="row mb-4">
        <div class="col">
            <h1>Dashboard Administrateur</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-people"></i> Gestion des Utilisateurs
                    </h5>
                    <p class="card-text">Gérer les comptes utilisateurs et leurs droits.</p>
                    <a href="/admin/profiles" class="btn btn-primary">Voir les utilisateurs</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-gear"></i> Gestion des Compétences
                    </h5>
                    <p class="card-text">Gérer les compétences disponibles.</p>
                    <a href="/admin/skills" class="btn btn-primary">Gérer les compétences</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-folder"></i> Gestion des Projets
                    </h5>
                    <p class="card-text">Voir tous les projets des utilisateurs.</p>
                    <a href="/admin/projects" class="btn btn-primary">Voir les projets</a>
                </div>
            </div>
        </div>
    </div>
</div> 
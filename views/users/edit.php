<?php $title = 'Modifier mon profil'; ?>

<style>
.profile-form {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.profile-form .card {
    border: none;
    box-shadow: 0 0 15px rgba(0,0,0,0.1);
    border-radius: 12px;
}

.profile-form .card-header {
    background: #007bff;
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 1.5rem;
}

.profile-form .card-body {
    padding: 2rem;
}

.profile-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 1rem;
}

.profile-picture-preview {
    text-align: center;
    margin-bottom: 2rem;
}
</style>

<div class="container profile-form">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title mb-0">Modifier mon profil</h2>
        </div>
        <div class="card-body">
            <form action="/profile/update" method="POST" enctype="multipart/form-data">
                <div class="profile-picture-preview mb-4">
                    <?php if ($user['avatar_path']): ?>
                        <img src="/<?= htmlspecialchars($user['avatar_path']) ?>" 
                             alt="Photo de profil" 
                             class="profile-picture">
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="<?= htmlspecialchars($user['email']) ?>" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="firstname" class="form-label">Prénom</label>
                    <input type="text" 
                           class="form-control" 
                           id="firstname" 
                           name="firstname" 
                           value="<?= htmlspecialchars($user['firstname'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="lastname" class="form-label">Nom</label>
                    <input type="text" 
                           class="form-control" 
                           id="lastname" 
                           name="lastname" 
                           value="<?= htmlspecialchars($user['lastname'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Biographie</label>
                    <textarea class="form-control" 
                              id="bio" 
                              name="bio" 
                              rows="4"><?= htmlspecialchars($user['bio'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Photo de profil</label>
                    <input type="file" 
                           class="form-control" 
                           id="avatar" 
                           name="avatar" 
                           accept="image/*">
                </div>

                <div class="mb-4">
                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                    <input type="password" 
                           class="form-control" 
                           id="current_password" 
                           name="current_password">
                    <div class="form-text">Requis pour confirmer les modifications</div>
                </div>

                <div class="mb-3">
                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                    <input type="password" 
                           class="form-control" 
                           id="new_password" 
                           name="new_password">
                    <div class="form-text">Laissez vide pour garder le mot de passe actuel</div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> Enregistrer les modifications
                    </button>
                    <a href="/profile" class="btn btn-outline-secondary">
                        <i class="bi bi-x-lg"></i> Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>
</div> 
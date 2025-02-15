<?php $title = 'Modifier l\'utilisateur'; ?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title mb-0">Modifier l'utilisateur</h2>
                </div>
                <div class="card-body">
                    <form action="/admin/users/edit/<?= $user['id'] ?>" method="POST">
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
                            <label for="password" class="form-label">
                                Nouveau mot de passe (laisser vide pour ne pas changer)
                            </label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password">
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" 
                                   class="form-check-input" 
                                   id="is_admin" 
                                   name="is_admin" 
                                   <?= $user['is_admin'] ? 'checked' : '' ?>>
                            <label class="form-check-label" for="is_admin">
                                Administrateur
                            </label>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="/admin/users" class="btn btn-secondary">Retour</a>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
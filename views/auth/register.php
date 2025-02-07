<?php $title = 'Inscription'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-card card">
                <div class="form-header">
                    <h2 class="mb-0">Inscription</h2>
                </div>
                
                <div class="form-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="/register">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" 
                                   class="form-control" 
                                   id="email" 
                                   name="email" 
                                   value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <div class="password-toggle">
                                <input type="password" 
                                       class="form-control" 
                                       id="password" 
                                       name="password" 
                                       required>
                                <i class="bi bi-eye toggle-icon"></i>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                            <div class="password-toggle">
                                <input type="password" 
                                       class="form-control" 
                                       id="confirm_password" 
                                       name="confirm_password" 
                                       required>
                                <i class="bi bi-eye toggle-icon"></i>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">S'inscrire</button>
                        </div>
                    </form>

                    <div class="form-footer">
                        <p class="mb-0">
                            Déjà inscrit ? 
                            <a href="/login" class="text-primary">Se connecter</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script pour afficher/masquer le mot de passe -->
<script>
document.querySelectorAll('.toggle-icon').forEach(icon => {
    icon.addEventListener('click', function() {
        const input = this.previousElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            this.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            input.type = 'password';
            this.classList.replace('bi-eye-slash', 'bi-eye');
        }
    });
});
</script> 
<?php if ($user['avatar_path']): ?>
    <img src="/<?= htmlspecialchars($user['avatar_path']) ?>" 
         alt="Avatar" 
         class="profile-avatar">
<?php endif; ?> 

<?php foreach ($projects as $project): ?>
    <div class="project-card">
        <?php if ($project['image_path']): ?>
            <img src="/public/<?= htmlspecialchars($project['image_path']) ?>" 
                 alt="<?= htmlspecialchars($project['title']) ?>"
                 class="project-image">
        <?php endif; ?>
        <!-- ... reste du code ... -->
    </div>
<?php endforeach; ?> 
<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Preload des ressources critiques -->
    <link rel="preload" href="/public/css/style.css" as="style">
    <link rel="preload" href="/public/js/app.js" as="script">
    
    <!-- Chargement différé des images -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var lazyImages = [].slice.call(document.querySelectorAll("img.lazy"));
            if ("IntersectionObserver" in window) {
                let lazyImageObserver = new IntersectionObserver(function(entries, observer) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            let lazyImage = entry.target;
                            lazyImage.src = lazyImage.dataset.src;
                            lazyImage.classList.remove("lazy");
                            lazyImageObserver.unobserve(lazyImage);
                        }
                    });
                });

                lazyImages.forEach(function(lazyImage) {
                    lazyImageObserver.observe(lazyImage);
                });
            }
        });
    </script>
</head>
<body>
    <!-- Toast container pour les notifications -->
    <div id="toast-container" class="toast-container"></div>
    
    <!-- Contenu de la page -->
    <?= $content ?>
    
    <!-- Scripts chargés de manière asynchrone -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.7.1/gsap.min.js" defer></script>
    <script src="/public/js/app.js" defer></script>
</body>
</html> 
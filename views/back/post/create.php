<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une publication - Back-Office GameCycle</title>
    <link rel="stylesheet" href="assets/css/global.css">
    <script src="assets/js/validation.js" defer></script>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <nav class="navbar">
                <div class="logo">
                    <span>GameCycle</span>
                </div>
                <ul class="nav-links">
                    <li><a href="index.php?page=posts" class="nav-link">Front-Office</a></li>
                    <li><a href="index.php?page=admin-posts" class="nav-link active">Posts</a></li>
                    <li><a href="index.php?page=admin-comments" class="nav-link">Commentaires</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb / Retour -->
        <div style="margin: 2rem 0;">
            <a href="index.php?page=admin-posts" class="btn btn-outline btn-small">← Retour à la liste</a>
        </div>

        <h1 class="section-title">Créer une publication</h1>

        <!-- Alerts -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-container form-mode-create">
            <form action="index.php?page=admin-post-store" method="POST">
                <input type="hidden" name="author_id" value="1">

                <!-- Titre -->
                <div class="form-group">
                    <label for="title">Titre de la publication *</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        placeholder="Ex: Découvrez notre nouvelle fonctionnalité..."
                        required
                    >
                </div>

                <!-- Contenu -->
                <div class="form-group">
                    <label for="content">Contenu *</label>
                    <textarea
                        name="content"
                        id="content"
                        class="form-control"
                        rows="12"
                        placeholder="Rédigez le contenu de votre publication..."
                        required
                    ></textarea>
                </div>

                <!-- Statut -->
                <div class="form-group">
                    <label for="status">Statut *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="DRAFT">📝 Brouillon (non visible)</option>
                        <option value="PUBLISHED">✅ Publié (visible par tous)</option>
                        <option value="ARCHIVED">📦 Archivé</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-success btn-large">
                        ✓ Créer la publication
                    </button>
                    <a href="index.php?page=admin-posts" class="btn btn-outline">
                        Annuler
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>GameCycle Back-Office</h3>
                    <p>Administration de la plateforme</p>
                </div>
                <div class="footer-section">
                    <p>&copy; <?= date('Y') ?> GameCycle - Back-Office</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

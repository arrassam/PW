<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier mon commentaire - GameCycle</title>
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
                    <li><a href="index.php?page=home" class="nav-link">Accueil</a></li>
                    <li><a href="index.php?page=posts" class="nav-link active">Communauté</a></li>
                    <li><a href="index.php?page=admin-posts" class="nav-link">Back-Office</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Breadcrumb / Retour -->
        <div style="margin: 2rem 0;">
            <a href="index.php?page=post&id=<?= $comment['post_id'] ?>" class="btn btn-outline btn-small">← Retour au post</a>
        </div>

        <h1 class="section-title">Modifier mon commentaire</h1>

        <!-- Alerts -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-container form-mode-edit">
            <form action="index.php?page=comment-update&id=<?= $comment['id'] ?>" method="POST">
                <div class="form-group">
                    <label for="comment_content">Votre commentaire *</label>
                    <textarea
                        name="content"
                        id="comment_content"
                        class="form-control"
                        rows="8"
                        placeholder="Modifiez votre commentaire..."
                    ><?= htmlspecialchars($comment['content']) ?></textarea>
                </div>

                <!-- Meta info -->
                <div class="event-stats">
                    <div class="stat-item">
                        <span class="stat-label">Créé le</span>
                        <span class="stat-value" style="font-size: 1rem; color: var(--secondary);">
                            <?= date('d/m/Y à H:i', strtotime($comment['created_at'])) ?>
                        </span>
                    </div>
                    <?php if (isset($comment['updated_at']) && $comment['updated_at'] != $comment['created_at']): ?>
                    <div class="stat-item">
                        <span class="stat-label">Modifié le</span>
                        <span class="stat-value" style="font-size: 1rem; color: var(--secondary);">
                            <?= date('d/m/Y à H:i', strtotime($comment['updated_at'])) ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning btn-large">
                        ✓ Mettre à jour
                    </button>
                    <a href="index.php?page=post&id=<?= $comment['post_id'] ?>" class="btn btn-outline">
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
                    <h3>GameCycle</h3>
                    <p>La plateforme gaming qui respecte la planète 🌍</p>
                </div>
                <div class="footer-section">
                    <p>&copy; <?= date('Y') ?> GameCycle - Tous droits réservés</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

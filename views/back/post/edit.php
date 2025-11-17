<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Éditer la publication - Back-Office GameCycle</title>
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

        <h1 class="section-title">Éditer la publication #<?= $post['id'] ?></h1>

        <!-- Alerts -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <div class="form-container form-mode-edit">
            <form action="index.php?page=admin-post-update&id=<?= $post['id'] ?>" method="POST">
                <!-- Titre -->
                <div class="form-group">
                    <label for="title">Titre de la publication *</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control"
                        value="<?= htmlspecialchars($post['title']) ?>"
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
                        required
                    ><?= htmlspecialchars($post['content']) ?></textarea>
                </div>

                <!-- Statut -->
                <div class="form-group">
                    <label for="status">Statut *</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="DRAFT" <?= $post['status'] === 'DRAFT' ? 'selected' : '' ?>>
                            📝 Brouillon (non visible)
                        </option>
                        <option value="PUBLISHED" <?= $post['status'] === 'PUBLISHED' ? 'selected' : '' ?>>
                            ✅ Publié (visible par tous)
                        </option>
                        <option value="ARCHIVED" <?= $post['status'] === 'ARCHIVED' ? 'selected' : '' ?>>
                            📦 Archivé
                        </option>
                    </select>
                </div>

                <!-- Meta info -->
                <div class="event-stats">
                    <div class="stat-item">
                        <span class="stat-label">Créé le</span>
                        <span class="stat-value" style="font-size: 1rem; color: var(--secondary);">
                            <?= date('d/m/Y à H:i', strtotime($post['created_at'])) ?>
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Modifié le</span>
                        <span class="stat-value" style="font-size: 1rem; color: var(--secondary);">
                            <?= date('d/m/Y à H:i', strtotime($post['updated_at'])) ?>
                        </span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Auteur</span>
                        <span class="stat-value" style="font-size: 1rem; color: var(--secondary);">
                            #<?= $post['author_id'] ?>
                        </span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-warning btn-large">
                        ✓ Mettre à jour
                    </button>
                    <a href="index.php?page=admin-posts" class="btn btn-outline">
                        Annuler
                    </a>
                    <a
                        href="index.php?page=admin-post-delete&id=<?= $post['id'] ?>"
                        class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?')"
                    >
                        🗑️ Supprimer
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> - GameCycle</title>
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
            <a href="index.php?page=posts" class="btn btn-outline btn-small">← Retour aux discussions</a>
        </div>

        <!-- Alerts -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_SESSION['success']) ?>
                <?php unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-error">
                <?= htmlspecialchars($_SESSION['error']) ?>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Post Detail Card -->
        <article class="event-card">
            <div class="event-header">
                <h1 class="event-title"><?= htmlspecialchars($post['title']) ?></h1>
                <div class="event-meta">
                    <div>👤 Auteur #<?= htmlspecialchars($post['author_id']) ?></div>
                    <div>📅 <?= date('d/m/Y à H:i', strtotime($post['created_at'])) ?></div>
                    <div><span class="gc-badge"><?= htmlspecialchars($post['status']) ?></span></div>
                </div>
            </div>
            <div class="event-details">
                <div class="event-description">
                    <?= nl2br(htmlspecialchars($post['content'])) ?>
                </div>
            </div>
        </article>

        <!-- Comments Section -->
        <div style="margin-top: 3rem;">
            <h2 class="section-title">💬 Commentaires (<?= count($comments) ?>)</h2>

            <!-- Comments List -->
            <?php if (empty($comments)): ?>
                <div class="no-events">
                    <p>Aucun commentaire pour le moment. Soyez le premier à commenter !</p>
                </div>
            <?php else: ?>
                <div style="margin-top: 2rem;">
                    <?php foreach ($comments as $comment): ?>
                        <div class="event-card" style="margin-bottom: 1.5rem;">
                            <div class="event-details">
                                <div class="event-meta" style="margin-bottom: 1rem;">
                                    <div>👤 Auteur #<?= htmlspecialchars($comment['author_id']) ?></div>
                                    <div>📅 <?= date('d/m/Y à H:i', strtotime($comment['created_at'])) ?></div>
                                    <?php if (isset($comment['updated_at']) && $comment['updated_at'] != $comment['created_at']): ?>
                                        <div style="color: var(--secondary); font-size: 0.85rem;">✏️ Modifié</div>
                                    <?php endif; ?>
                                </div>
                                <p class="event-description">
                                    <?= nl2br(htmlspecialchars($comment['content'])) ?>
                                </p>
                                
                                <!-- Actions utilisateur (si c'est son commentaire) -->
                                <?php 
                                    // TODO: Remplacer par $_SESSION['user_id'] quand l'authentification sera en place
                                    $currentUserId = 1;
                                    if ($comment['author_id'] == $currentUserId): 
                                ?>
                                <div class="event-actions-crud" style="margin-top: 1rem;">
                                    <a href="index.php?page=comment-edit&id=<?= $comment['id'] ?>" class="btn btn-outline btn-small">
                                        ✏️ Modifier
                                    </a>
                                    <a 
                                        href="index.php?page=comment-delete&id=<?= $comment['id'] ?>" 
                                        class="btn btn-danger btn-small"
                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?')"
                                    >
                                        🗑️ Supprimer
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Add Comment Form -->
            <div class="form-container form-mode-create" style="margin-top: 3rem;">
                <h3 style="margin-bottom: 1.5rem; color: var(--light);">Ajouter un commentaire</h3>
                <form action="index.php?page=comment-store" method="POST">
                    <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                    <input type="hidden" name="author_id" value="1">

                    <div class="form-group">
                        <label for="comment_content">Votre commentaire</label>
                        <textarea
                            name="content"
                            id="comment_content"
                            class="form-control"
                            rows="5"
                            placeholder="Partagez votre avis, posez une question..."
                        ></textarea>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            Publier le commentaire
                        </button>
                    </div>
                </form>
            </div>
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

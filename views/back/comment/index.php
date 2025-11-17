<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des commentaires - Back-Office GameCycle</title>
    <link rel="stylesheet" href="assets/css/global.css">
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
                    <li><a href="index.php?page=admin-posts" class="nav-link">Posts</a></li>
                    <li><a href="index.php?page=admin-comments" class="nav-link active">Commentaires</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="manage-header">
            <div class="manage-title">
                <h1 class="section-title">Gestion des commentaires</h1>
            </div>
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

        <!-- Stats -->
        <div class="impact-stats">
            <div class="stat-card">
                <div class="stat-number"><?= count($comments) ?></div>
                <div class="stat-label">Commentaires totaux</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?= count(array_filter($comments, fn($c) => $c['status'] === 'PUBLISHED')) ?>
                </div>
                <div class="stat-label">Publiés</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?= count(array_filter($comments, fn($c) => $c['status'] === 'HIDDEN')) ?>
                </div>
                <div class="stat-label">Masqués</div>
            </div>
        </div>

        <!-- Comments List -->
        <?php if (empty($comments)): ?>
            <div class="no-events">
                <h3>Aucun commentaire</h3>
                <p>Les commentaires apparaîtront ici une fois que les utilisateurs commenceront à interagir.</p>
            </div>
        <?php else: ?>
            <div class="events-grid">
                <?php foreach ($comments as $comment): ?>
                    <article class="event-card <?= $comment['status'] === 'HIDDEN' ? 'event-cancelled' : '' ?>">
                        <div class="event-header">
                            <h3 class="event-title">
                                Commentaire #<?= $comment['id'] ?>
                            </h3>
                            <p class="event-creator">
                                Sur le post : <strong><?= htmlspecialchars($comment['post_title']) ?></strong>
                            </p>
                        </div>
                        <div class="event-details">
                            <p class="event-description">
                                <?php
                                    $content = htmlspecialchars($comment['content']);
                                    echo mb_strlen($content) > 200 ? mb_substr($content, 0, 200) . '...' : $content;
                                ?>
                            </p>
                            <div class="event-meta">
                                <div>👤 Auteur #<?= htmlspecialchars($comment['author_id']) ?></div>
                                <div>📅 <?= date('d/m/Y à H:i', strtotime($comment['created_at'])) ?></div>
                                <div>
                                    <?php if ($comment['status'] === 'PUBLISHED'): ?>
                                        <span class="gc-badge">✅ Publié</span>
                                    <?php else: ?>
                                        <span style="padding: 0.3rem 0.8rem; background: var(--danger); color: white; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">
                                            🚫 Masqué
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="event-actions-crud">
                                <a href="index.php?page=post&id=<?= $comment['post_id'] ?>" class="btn btn-outline btn-small">
                                    👁️ Voir le post
                                </a>
                                <?php if ($comment['status'] === 'PUBLISHED'): ?>
                                    <a
                                        href="index.php?page=admin-comment-hide&id=<?= $comment['id'] ?>"
                                        class="btn btn-warning btn-small"
                                        onclick="return confirm('Masquer ce commentaire ?')"
                                    >
                                        🚫 Masquer
                                    </a>
                                <?php else: ?>
                                    <a
                                        href="index.php?page=admin-comment-publish&id=<?= $comment['id'] ?>"
                                        class="btn btn-success btn-small"
                                        onclick="return confirm('Publier ce commentaire ?')"
                                    >
                                        ✅ Publier
                                    </a>
                                <?php endif; ?>
                                <a
                                    href="index.php?page=admin-comment-delete&id=<?= $comment['id'] ?>"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce commentaire ?')"
                                >
                                    🗑️ Supprimer
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des publications - Back-Office GameCycle</title>
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
                    <li><a href="index.php?page=admin-posts" class="nav-link active">Posts</a></li>
                    <li><a href="index.php?page=admin-comments" class="nav-link">Commentaires</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Page Header -->
        <div class="manage-header">
            <div class="manage-title">
                <h1 class="section-title">Gestion des publications</h1>
            </div>
            <a href="index.php?page=admin-post-create" class="btn btn-success btn-large">
                + Nouvelle publication
            </a>
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
                <div class="stat-number"><?= count($posts) ?></div>
                <div class="stat-label">Publications totales</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?= count(array_filter($posts, fn($p) => $p['status'] === 'PUBLISHED')) ?>
                </div>
                <div class="stat-label">Publiées</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">
                    <?= count(array_filter($posts, fn($p) => $p['status'] === 'DRAFT')) ?>
                </div>
                <div class="stat-label">Brouillons</div>
            </div>
        </div>

        <!-- Posts List -->
        <?php if (empty($posts)): ?>
            <div class="no-events">
                <h3>Aucune publication</h3>
                <p>Créez votre première publication pour commencer.</p>
                <a href="index.php?page=admin-post-create" class="btn btn-primary" style="margin-top: 1rem;">
                    Créer une publication
                </a>
            </div>
        <?php else: ?>
            <div class="events-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="event-card">
                        <div class="event-header">
                            <h3 class="event-title"><?= htmlspecialchars($post['title']) ?></h3>
                            <p class="event-creator">ID: #<?= $post['id'] ?> | Auteur #<?= htmlspecialchars($post['author_id']) ?></p>
                        </div>
                        <div class="event-details">
                            <div class="event-meta">
                                <div>📅 <?= date('d/m/Y à H:i', strtotime($post['created_at'])) ?></div>
                                <div>
                                    <?php
                                        $statusClass = '';
                                        $statusText = $post['status'];
                                        switch($post['status']) {
                                            case 'PUBLISHED':
                                                $statusClass = 'gc-badge';
                                                $statusText = '✅ Publié';
                                                break;
                                            case 'DRAFT':
                                                $statusText = '📝 Brouillon';
                                                break;
                                            case 'ARCHIVED':
                                                $statusText = '📦 Archivé';
                                                break;
                                        }
                                    ?>
                                    <span class="<?= $statusClass ?>"><?= $statusText ?></span>
                                </div>
                            </div>
                            <p class="event-description">
                                <?php
                                    $content = htmlspecialchars($post['content']);
                                    echo mb_strlen($content) > 120 ? mb_substr($content, 0, 120) . '...' : $content;
                                ?>
                            </p>
                            <div class="event-actions-crud">
                                <a href="index.php?page=post&id=<?= $post['id'] ?>" class="btn btn-outline btn-small">
                                    👁️ Voir
                                </a>
                                <a href="index.php?page=admin-post-edit&id=<?= $post['id'] ?>" class="btn btn-warning btn-small">
                                    ✏️ Éditer
                                </a>
                                <a
                                    href="index.php?page=admin-post-delete&id=<?= $post['id'] ?>"
                                    class="btn btn-danger btn-small"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette publication ?')"
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

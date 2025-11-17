<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Communauté GameCycle</title>
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
                    <li><a href="index.php?page=home" class="nav-link">Accueil</a></li>
                    <li><a href="index.php?page=posts" class="nav-link active">Communauté</a></li>
                    <li><a href="index.php?page=admin-posts" class="nav-link">Back-Office</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <div class="container">
        <!-- Hero Section -->
        <section class="hero">
            <h1>Communauté GameCycle</h1>
            <p>Échangez, partagez et discutez avec la communauté gaming écolo. Posez vos questions, partagez vos astuces et rejoignez la conversation !</p>
        </section>

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

        <!-- Posts Grid -->
        <div class="events-grid">
            <?php if (empty($posts)): ?>
                <div class="no-events">
                    <h3>Aucune publication pour le moment</h3>
                    <p>Soyez le premier à lancer une discussion !</p>
                </div>
            <?php else: ?>
                <?php foreach ($posts as $post): ?>
                    <article class="event-card">
                        <div class="event-header">
                            <h3 class="event-title"><?= htmlspecialchars($post['title']) ?></h3>
                            <p class="event-creator">Par Auteur #<?= htmlspecialchars($post['author_id']) ?></p>
                        </div>
                        <div class="event-details">
                            <p class="event-description">
                                <?php
                                    $content = htmlspecialchars($post['content']);
                                    echo mb_strlen($content) > 150 ? mb_substr($content, 0, 150) . '...' : $content;
                                ?>
                            </p>
                            <div class="event-meta">
                                <div>📅 <?= date('d/m/Y à H:i', strtotime($post['created_at'])) ?></div>
                                <div><span class="gc-badge">💬 Commentaires</span></div>
                            </div>
                            <div class="event-actions">
                                <span class="participants-count">
                                    Publié le <?= date('d/m/Y', strtotime($post['created_at'])) ?>
                                </span>
                                <a href="index.php?page=post&id=<?= $post['id'] ?>" class="btn btn-primary">
                                    Voir la discussion
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
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

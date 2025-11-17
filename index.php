<?php
/**
 * GAMECYCLE - ROUTER PRINCIPAL
 * Gère toutes les routes de l'application (Front + Back Office)
 */

// Démarrage de la session
session_start();

// Gestion des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Récupération de la page demandée
$page = $_GET['page'] ?? 'home';
$id = $_GET['id'] ?? null;
$action = $_GET['action'] ?? null;

// ================================================
// FRONT-OFFICE - Routes publiques
// ================================================

if ($page === 'home' || $page === 'posts') {
    require_once __DIR__ . '/controllers/PostController.php';
    $controller = new PostController();
    $controller->index();
    exit;
}

if ($page === 'post' && $id) {
    require_once __DIR__ . '/controllers/PostController.php';
    $controller = new PostController();
    $controller->show($id);
    exit;
}

if ($page === 'comment-store') {
    require_once __DIR__ . '/controllers/CommentController.php';
    $controller = new CommentController();
    $controller->store();
    exit;
}

if ($page === 'comment-edit' && $id) {
    require_once __DIR__ . '/controllers/CommentController.php';
    $controller = new CommentController();
    $controller->edit($id);
    exit;
}

if ($page === 'comment-update' && $id) {
    require_once __DIR__ . '/controllers/CommentController.php';
    $controller = new CommentController();
    $controller->update($id);
    exit;
}

if ($page === 'comment-delete' && $id) {
    require_once __DIR__ . '/controllers/CommentController.php';
    $controller = new CommentController();
    $controller->destroy($id);
    exit;
}

// ================================================
// BACK-OFFICE - Routes admin
// ================================================

// Liste des posts (admin)
if ($page === 'admin-posts') {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->index();
    exit;
}

// Créer un post (admin)
if ($page === 'admin-post-create') {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->create();
    exit;
}

// Enregistrer un post (admin)
if ($page === 'admin-post-store') {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->store();
    exit;
}

// Éditer un post (admin)
if ($page === 'admin-post-edit' && $id) {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->edit($id);
    exit;
}

// Mettre à jour un post (admin)
if ($page === 'admin-post-update' && $id) {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->update($id);
    exit;
}

// Supprimer un post (admin)
if ($page === 'admin-post-delete' && $id) {
    require_once __DIR__ . '/back/controllers/AdminPostController.php';
    $controller = new AdminPostController();
    $controller->destroy($id);
    exit;
}

// Liste des commentaires (admin)
if ($page === 'admin-comments') {
    require_once __DIR__ . '/back/controllers/AdminCommentController.php';
    $controller = new AdminCommentController();
    $controller->index();
    exit;
}

// Masquer un commentaire (admin)
if ($page === 'admin-comment-hide' && $id) {
    require_once __DIR__ . '/back/controllers/AdminCommentController.php';
    $controller = new AdminCommentController();
    $controller->hide($id);
    exit;
}

// Publier un commentaire (admin)
if ($page === 'admin-comment-publish' && $id) {
    require_once __DIR__ . '/back/controllers/AdminCommentController.php';
    $controller = new AdminCommentController();
    $controller->publish($id);
    exit;
}

// Supprimer un commentaire (admin)
if ($page === 'admin-comment-delete' && $id) {
    require_once __DIR__ . '/back/controllers/AdminCommentController.php';
    $controller = new AdminCommentController();
    $controller->destroy($id);
    exit;
}

// ================================================
// PAGE PAR DÉFAUT - 404
// ================================================
http_response_code(404);
echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>404 - Page non trouvée | GameCycle</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1a1a1a;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .error-container {
            text-align: center;
        }
        h1 {
            font-size: 5rem;
            margin: 0;
            color: #ff4757;
        }
        p {
            font-size: 1.5rem;
        }
        a {
            color: #5352ed;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class='error-container'>
        <h1>404</h1>
        <p>Page non trouvée</p>
        <a href='index.php?page=posts'>← Retour aux posts</a>
    </div>
</body>
</html>";
?>

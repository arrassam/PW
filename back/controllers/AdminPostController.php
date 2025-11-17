<?php
/**
 * AdminPostController - BACK-OFFICE
 * Gestion des publications côté administrateur
 */

require_once __DIR__ . '/../../models/PostModel.php';

class AdminPostController {
    private $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    /**
     * Affiche la liste de tous les posts
     */
    public function index() {
        $posts = $this->postModel->getAll();
        require_once __DIR__ . '/../../views/back/post/index.php';
    }

    /**
     * Affiche le formulaire de création
     */
    public function create() {
        require_once __DIR__ . '/../../views/back/post/create.php';
    }

    /**
     * Enregistre un nouveau post
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'author_id' => $_POST['author_id'] ?? 1,
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'status' => $_POST['status'] ?? 'DRAFT'
            ];

            if ($this->postModel->create($data)) {
                $_SESSION['success'] = 'Publication créée avec succès !';
                header('Location: index.php?page=admin-posts');
            } else {
                $_SESSION['error'] = 'Erreur lors de la création de la publication.';
                header('Location: index.php?page=admin-post-create');
            }
            exit;
        }
    }

    /**
     * Affiche le formulaire d'édition
     */
    public function edit($id) {
        $post = $this->postModel->getById($id);

        if (!$post) {
            $_SESSION['error'] = 'Publication introuvable.';
            header('Location: index.php?page=admin-posts');
            exit;
        }

        require_once __DIR__ . '/../../views/back/post/edit.php';
    }

    /**
     * Met à jour un post
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'] ?? '',
                'content' => $_POST['content'] ?? '',
                'status' => $_POST['status'] ?? 'DRAFT'
            ];

            if ($this->postModel->update($id, $data)) {
                $_SESSION['success'] = 'Publication mise à jour avec succès !';
            } else {
                $_SESSION['error'] = 'Erreur lors de la mise à jour.';
            }

            header('Location: index.php?page=admin-post-edit&id=' . $id);
            exit;
        }
    }

    /**
     * Supprime un post
     */
    public function destroy($id) {
        if ($this->postModel->delete($id)) {
            $_SESSION['success'] = 'Publication supprimée avec succès.';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression.';
        }

        header('Location: index.php?page=admin-posts');
        exit;
    }
}
?>

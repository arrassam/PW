<?php
/**
 * CommentController - FRONT-OFFICE
 * Gestion des commentaires côté visiteur
 */

require_once __DIR__ . '/../models/CommentModel.php';

class CommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    /**
     * Crée un nouveau commentaire
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'post_id' => $_POST['post_id'] ?? 0,
                'author_id' => $_POST['author_id'] ?? 1, // TODO: Remplacer par l'utilisateur connecté
                'content' => $_POST['content'] ?? ''
            ];

            if ($this->commentModel->create($data)) {
                $_SESSION['success'] = 'Commentaire ajouté avec succès !';
            } else {
                $_SESSION['error'] = 'Erreur lors de l\'ajout du commentaire.';
            }

            header('Location: index.php?page=post&id=' . $data['post_id']);
            exit;
        }
    }

    /**
     * Affiche le formulaire d'édition d'un commentaire
     */
    public function edit($id) {
        $comment = $this->commentModel->getById($id);

        if (!$comment) {
            $_SESSION['error'] = 'Commentaire introuvable.';
            header('Location: index.php?page=posts');
            exit;
        }

        // TODO: Vérifier que l'utilisateur est l'auteur du commentaire
        // if ($comment['author_id'] != $_SESSION['user_id']) { ... }

        require_once __DIR__ . '/../views/front/comment/edit.php';
    }

    /**
     * Met à jour un commentaire
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $comment = $this->commentModel->getById($id);

            if (!$comment) {
                $_SESSION['error'] = 'Commentaire introuvable.';
                header('Location: index.php?page=posts');
                exit;
            }

            // TODO: Vérifier que l'utilisateur est l'auteur
            // if ($comment['author_id'] != $_SESSION['user_id']) { ... }

            $data = [
                'content' => $_POST['content'] ?? ''
            ];

            if ($this->commentModel->update($id, $data)) {
                $_SESSION['success'] = 'Commentaire modifié avec succès !';
            } else {
                $_SESSION['error'] = 'Erreur lors de la modification.';
            }

            header('Location: index.php?page=post&id=' . $comment['post_id']);
            exit;
        }
    }

    /**
     * Supprime un commentaire (utilisateur)
     */
    public function destroy($id) {
        $comment = $this->commentModel->getById($id);

        if (!$comment) {
            $_SESSION['error'] = 'Commentaire introuvable.';
            header('Location: index.php?page=posts');
            exit;
        }

        // TODO: Vérifier que l'utilisateur est l'auteur
        // if ($comment['author_id'] != $_SESSION['user_id']) { ... }

        $postId = $comment['post_id'];

        if ($this->commentModel->delete($id)) {
            $_SESSION['success'] = 'Commentaire supprimé avec succès.';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression.';
        }

        header('Location: index.php?page=post&id=' . $postId);
        exit;
    }
}
?>

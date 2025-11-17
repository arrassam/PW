<?php
/**
 * AdminCommentController - BACK-OFFICE
 * Gestion des commentaires côté administrateur
 */

require_once __DIR__ . '/../../models/CommentModel.php';

class AdminCommentController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new CommentModel();
    }

    /**
     * Affiche la liste de tous les commentaires
     */
    public function index() {
        $comments = $this->commentModel->getAll();
        require_once __DIR__ . '/../../views/back/comment/index.php';
    }

    /**
     * Masque un commentaire
     */
    public function hide($id) {
        if ($this->commentModel->hide($id)) {
            $_SESSION['success'] = 'Commentaire masqué avec succès.';
        } else {
            $_SESSION['error'] = 'Erreur lors du masquage du commentaire.';
        }

        header('Location: index.php?page=admin-comments');
        exit;
    }

    /**
     * Publie un commentaire masqué
     */
    public function publish($id) {
        if ($this->commentModel->publish($id)) {
            $_SESSION['success'] = 'Commentaire publié avec succès.';
        } else {
            $_SESSION['error'] = 'Erreur lors de la publication du commentaire.';
        }

        header('Location: index.php?page=admin-comments');
        exit;
    }

    /**
     * Supprime définitivement un commentaire
     */
    public function destroy($id) {
        if ($this->commentModel->delete($id)) {
            $_SESSION['success'] = 'Commentaire supprimé définitivement.';
        } else {
            $_SESSION['error'] = 'Erreur lors de la suppression du commentaire.';
        }

        header('Location: index.php?page=admin-comments');
        exit;
    }
}
?>

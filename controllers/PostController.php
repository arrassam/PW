<?php
/**
 * PostController - FRONT-OFFICE
 * Gestion des posts côté visiteur
 */

require_once __DIR__ . '/../models/PostModel.php';
require_once __DIR__ . '/../models/CommentModel.php';

class PostController {
    private $postModel;
    private $commentModel;

    public function __construct() {
        $this->postModel = new PostModel();
        $this->commentModel = new CommentModel();
    }

    /**
     * Liste tous les posts publiés
     */
    public function index() {
        $posts = $this->postModel->getAllPublished();
        require_once __DIR__ . '/../views/front/post/index.php';
    }

    /**
     * Affiche un post avec ses commentaires
     */
    public function show($id) {
        $post = $this->postModel->getById($id);

        if (!$post || $post['status'] !== 'PUBLISHED') {
            header('Location: index.php?page=posts');
            exit;
        }

        $comments = $this->commentModel->getByPostId($id);
        require_once __DIR__ . '/../views/front/post/show.php';
    }
}
?>

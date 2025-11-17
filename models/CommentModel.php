<?php
/**
 * CommentModel - Gestion des commentaires
 * Gère les opérations CRUD sur la table comment
 */

require_once __DIR__ . '/../config/database.php';

class CommentModel {
    private $conn;
    private $table = 'comment';

    /**
     * Constructeur - Initialise la connexion à la base de données
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Récupère tous les commentaires publiés pour un post donné
     * @param int $postId ID du post
     * @return array Liste des commentaires publiés
     */
    public function getByPostId($postId) {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE post_id = :post_id AND status = 'PUBLISHED'
                  ORDER BY created_at ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les commentaires (pour le back-office)
     * @return array Liste de tous les commentaires avec info du post
     */
    public function getAll() {
        $query = "SELECT c.*, p.title as post_title
                  FROM " . $this->table . " c
                  INNER JOIN post p ON c.post_id = p.id
                  ORDER BY c.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un commentaire par son ID
     * @param int $id ID du commentaire
     * @return array|false Données du commentaire ou false si non trouvé
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau commentaire
     * @param array $data Données (post_id, author_id, content)
     * @return int|false ID du commentaire créé ou false en cas d'erreur
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (post_id, author_id, content, status)
                  VALUES (:post_id, :author_id, :content, 'PUBLISHED')";

        $stmt = $this->conn->prepare($query);

        // Nettoyage des données
        $data['content'] = htmlspecialchars($data['content']);

        // Liaison des paramètres
        $stmt->bindParam(':post_id', $data['post_id'], PDO::PARAM_INT);
        $stmt->bindParam(':author_id', $data['author_id'], PDO::PARAM_INT);
        $stmt->bindParam(':content', $data['content']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    /**
     * Met à jour un commentaire
     * @param int $id ID du commentaire
     * @param array $data Données à mettre à jour (content)
     * @return bool True si succès, false sinon
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET content = :content, updated_at = CURRENT_TIMESTAMP
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Nettoyage des données
        $data['content'] = htmlspecialchars($data['content']);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':content', $data['content']);

        return $stmt->execute();
    }

    /**
     * Masque un commentaire (change le statut en HIDDEN)
     * @param int $id ID du commentaire
     * @return bool True si succès, false sinon
     */
    public function hide($id) {
        $query = "UPDATE " . $this->table . "
                  SET status = 'HIDDEN'
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Rend visible un commentaire (change le statut en PUBLISHED)
     * @param int $id ID du commentaire
     * @return bool True si succès, false sinon
     */
    public function publish($id) {
        $query = "UPDATE " . $this->table . "
                  SET status = 'PUBLISHED'
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime un commentaire
     * @param int $id ID du commentaire à supprimer
     * @return bool True si succès, false sinon
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Compte le nombre de commentaires pour un post
     * @param int $postId ID du post
     * @return int Nombre de commentaires publiés
     */
    public function countByPostId($postId) {
        $query = "SELECT COUNT(*) as count
                  FROM " . $this->table . "
                  WHERE post_id = :post_id AND status = 'PUBLISHED'";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':post_id', $postId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'];
    }

    /**
     * Compte le nombre de commentaires par statut
     * @return array Tableau associatif avec les compteurs
     */
    public function countByStatus() {
        $query = "SELECT status, COUNT(*) as count
                  FROM " . $this->table . "
                  GROUP BY status";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $result[$row['status']] = $row['count'];
        }

        return $result;
    }
}
?>

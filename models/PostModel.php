<?php
/**
 * PostModel - Gestion des posts
 * Gère les opérations CRUD sur la table post
 */

require_once __DIR__ . '/../config/database.php';

class PostModel {
    private $conn;
    private $table = 'post';

    /**
     * Constructeur - Initialise la connexion à la base de données
     */
    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    /**
     * Récupère tous les posts publiés (pour le front-office)
     * @return array Liste des posts publiés, triés par date décroissante
     */
    public function getAllPublished() {
        $query = "SELECT * FROM " . $this->table . "
                  WHERE status = 'PUBLISHED'
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère tous les posts (pour le back-office)
     * @return array Liste de tous les posts
     */
    public function getAll() {
        $query = "SELECT * FROM " . $this->table . "
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un post par son ID
     * @param int $id ID du post
     * @return array|false Données du post ou false si non trouvé
     */
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Crée un nouveau post
     * @param array $data Données du post (title, content, author_id, status)
     * @return int|false ID du post créé ou false en cas d'erreur
     */
    public function create($data) {
        $query = "INSERT INTO " . $this->table . "
                  (title, content, author_id, status)
                  VALUES (:title, :content, :author_id, :status)";

        $stmt = $this->conn->prepare($query);

        // Nettoyage des données
        $data['title'] = htmlspecialchars(strip_tags($data['title']));
        $data['content'] = htmlspecialchars($data['content']);
        $data['status'] = isset($data['status']) ? $data['status'] : 'DRAFT';

        // Liaison des paramètres
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':author_id', $data['author_id'], PDO::PARAM_INT);
        $stmt->bindParam(':status', $data['status']);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        return false;
    }

    /**
     * Met à jour un post existant
     * @param int $id ID du post
     * @param array $data Nouvelles données (title, content, status)
     * @return bool True si succès, false sinon
     */
    public function update($id, $data) {
        $query = "UPDATE " . $this->table . "
                  SET title = :title,
                      content = :content,
                      status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Nettoyage des données
        $data['title'] = htmlspecialchars(strip_tags($data['title']));
        $data['content'] = htmlspecialchars($data['content']);

        // Liaison des paramètres
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':title', $data['title']);
        $stmt->bindParam(':content', $data['content']);
        $stmt->bindParam(':status', $data['status']);

        return $stmt->execute();
    }

    /**
     * Supprime un post
     * @param int $id ID du post à supprimer
     * @return bool True si succès, false sinon
     */
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Change le statut d'un post
     * @param int $id ID du post
     * @param string $status Nouveau statut (PUBLISHED, DRAFT, ARCHIVED)
     * @return bool True si succès, false sinon
     */
    public function changeStatus($id, $status) {
        $query = "UPDATE " . $this->table . "
                  SET status = :status
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    /**
     * Compte le nombre de posts par statut
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

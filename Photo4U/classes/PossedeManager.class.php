<?php
class PossedeManager
{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function addPossede($id_user, $id_photo)
    {
        try {
            // Vérifier si la relation existe déjà
            $query_check = "SELECT * FROM possede WHERE id_photo = :photo_id AND id_user = :user_id";
            $stmt_check = $this->_db->prepare($query_check);
            $stmt_check->bindParam(":photo_id", $id_photo);
            $stmt_check->bindParam(":user_id", $id_user);
            $stmt_check->execute();
            $existing_relation = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if (!$existing_relation) {
                // Insérer la relation dans la base de données
                $query = "INSERT INTO possede (id_photo, id_user) VALUES (:photo_id, :user_id)";
                $stmt = $this->_db->prepare($query);
                $stmt->bindParam(":photo_id", $id_photo);
                $stmt->bindParam(":user_id", $id_user);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function getPhotosIdsByUserId($userId)
    {
        try {
            // Préparer la requête SQL pour récupérer les identifiants des photos de l'utilisateur
            $query = "SELECT id_photo FROM possede WHERE id_user = :userId";
            $stmt = $this->_db->prepare($query);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->execute();

            // Récupérer les identifiants des photos de l'utilisateur sous forme de tableau
            $photoIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Retourner les identifiants des photos de l'utilisateur
            return $photoIds;
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            echo "Erreur: " . $e->getMessage();
            return [];
        }
    }



    public function deletePossede($id_user, $id_photo)
    {
        try {
            // Supprimer la relation de la base de données
            $query = "DELETE FROM possede WHERE id_photo = :photo_id AND id_user = :user_id";
            $stmt = $this->_db->prepare($query);
            $stmt->bindParam(":photo_id", $id_photo);
            $stmt->bindParam(":user_id", $id_user);
            $stmt->execute();
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
<?php
class PanierManager
{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->setDb($db);
    }

    public function addPanier($panier)
    {
        try {
            // Récupérer les valeurs des getters dans des variables
            $photo_id = $panier->getIdPhoto();
            $user_id = $panier->getIdUser();

            // Vérifier si l'utilisateur a déjà ajouté cette photo au panier
            $query_check = "SELECT * FROM panier WHERE id_photo = :photo_id AND id_user = :user_id";
            $stmt_check = $this->_db->prepare($query_check);
            $stmt_check->bindParam(":photo_id", $photo_id);
            $stmt_check->bindParam(":user_id", $user_id);
            $stmt_check->execute();
            $existing_panier = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if (!$existing_panier) {
                // Insérer le panier dans la base de données
                $query = "INSERT INTO panier (id_photo, id_user) VALUES (:photo_id, :user_id)";
                $stmt = $this->_db->prepare($query);
                $stmt->bindParam(":photo_id", $photo_id);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function getAllPanier()
    {
        try {
            // Préparer la requête SQL
            $query = "SELECT * FROM panier";

            // Exécuter la requête
            $stmt = $this->_db->prepare($query);
            $stmt->execute();

            // Récupérer les résultats sous forme de tableau associatif
            $paniers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Retourner les résultats
            return $paniers;
        } catch (PDOException $e) {
            // Gérer les erreurs éventuelles
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function deletePanier($id_panier)
    {
        // Préparation de la requête de suppression
        $query = "DELETE FROM panier WHERE id_panier = :id_panier";
        $stmt = $this->_db->prepare($query);

        // Liaison du paramètre
        $stmt->bindParam(':id_panier', $id_panier, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();
    }

    public function deletePanierByIdUser($id_user)
    {
        // Préparation de la requête de suppression
        $query = "DELETE FROM panier WHERE id_user = :id_user";
        $stmt = $this->_db->prepare($query);

        // Liaison du paramètre
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();
    }

    public function getPanierById($id_panier)
    {
        // Préparation de la requête de sélection
        $query = "SELECT * FROM panier WHERE id_panier = :id_panier";
        $stmt = $this->_db->prepare($query);

        // Liaison du paramètre
        $stmt->bindParam(':id_panier', $id_panier, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();

        // Récupération du résultat
        $donnees = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Panier($donnees);
    }

    public function getPanierUser($id_user, $id_photo)
    {
        // Préparation de la requête de sélection
        $query = "SELECT * FROM panier WHERE id_user = :id_user AND id_photo = :id_photo";
        $stmt = $this->_db->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_photo', $id_photo, PDO::PARAM_INT);

        // Exécution de la requête
        $stmt->execute();

        // Récupération du résultat
        $donnees = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($donnees) {
            return new Panier($donnees);
        } else {
            return null; // Si aucun résultat trouvé, retourner null
        }
    }

    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
?>
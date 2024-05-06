<?php
class PhotoManager
{
    private $_db;

    public function __construct(PDO $db)
    {
        $this->_db = $db;
    }

    public function addPhoto(Photo $photo)
    {
        $q = $this->_db->prepare('INSERT INTO photos (nom_photo, taille_pixels_x, taille_pixels_y, poids, nbrdephoto, lien, prix, description) VALUES (:nom_photo, :taillepx_x, :taillepx_y, :poids, :nbrdephoto, :lien, :prix, :description)');

        $q->bindValue(':nom_photo', $photo->getNomPhoto());
        $q->bindValue(':taillepx_x', $photo->getTaillePixelsX());
        $q->bindValue(':taillepx_y', $photo->getTaillePixelsY());
        $q->bindValue(':poids', $photo->getPoids());
        $q->bindValue(':nbrdephoto', $photo->getNbrDePhoto()); // Utilisation de la méthode statique de la classe Photo
        $q->bindValue(':lien', $photo->getLien());
        $q->bindValue(':prix', $photo->getPrix());
        $q->bindValue(':description', $photo->getDescription());

        $q->execute();

        $photo->setIdPhoto($this->_db->lastInsertId());
    }
    public function supprimerPhoto($idPhoto)
    {
        $q = $this->_db->prepare('DELETE FROM photos WHERE id_photo = :id');
        $q->bindValue(':id', $idPhoto, PDO::PARAM_INT);
        $q->execute();
    }

    public function modifierPhoto(Photo $photo)
    {
        $q = $this->_db->prepare('UPDATE photos SET nom_photo = :nom_photo, taille_pixels_x = :taillepx_x, taille_pixels_y = :taillepx_y, poids = :poids, lien = :lien, description = :description WHERE id_photo = :id');

        $q->bindValue(':nom_photo', $photo->getNomPhoto());
        $q->bindValue(':taillepx_x', $photo->getTaillePixelsX());
        $q->bindValue(':taillepx_y', $photo->getTaillePixelsY());
        $q->bindValue(':poids', $photo->getPoids());
        $q->bindValue(':lien', $photo->getLien());
        $q->bindValue(':description', $photo->getDescription());
        $q->bindValue(':id', $photo->getIdPhoto(), PDO::PARAM_INT);

        $q->execute();
    }

    public function updatePhotoQuantity($photoId, $quantity)
    {
        $q = $this->_db->prepare('UPDATE photos SET nbrdephoto = nbrdephoto - :quantity WHERE id_photo = :photoId');
        $q->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $q->bindValue(':photoId', $photoId, PDO::PARAM_INT);
        $q->execute();
    }


    public function getAllPhotos()
    {
        $q = $this->_db->prepare('SELECT * FROM photos');
        $q->execute();
        $results = $q->fetchAll(PDO::FETCH_ASSOC);

        $photos = [];

        foreach ($results as $result) {
            $photo = new Photo($result);
            $photos[] = $photo;
        }

        return $photos;
    }

    public function getPhotoById($id)
    {
        try {
            $q = $this->_db->prepare('SELECT * FROM photos WHERE id_photo = :id');
            $q->bindValue(':id', $id, PDO::PARAM_INT);
            $q->execute();
            $result = $q->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Créer une nouvelle instance de Photo avec les données récupérées de la base de données
                $photo = new Photo($result);
                return $photo;
            } else {
                // Retourner null si aucune photo n'est trouvée avec l'ID donné
                return null;
            }
        } catch (PDOException $e) {
            echo "Une erreur PDO s'est produite : " . $e->getMessage();
        }
    }




    public function setDb(PDO $db)
    {
        $this->_db = $db;
    }
}
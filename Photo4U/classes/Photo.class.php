<?php
class Photo
{
    private $_id_photo;
    private $_nom_photo;
    private $_taille_pixels_x; // Ajustement du nom de la propriété
    private $_taille_pixels_y; // Ajustement du nom de la propriété
    private $_poids;
    private $_nbrdephoto;
    private $_lien;
    private $_description;

    private $_prix;

    public function __construct(array $donnees = [])
    {
        $this->hydrate($donnees);
    }

    // Modifier la méthode hydrate pour utiliser les clés correctes
    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            // Convertir les clés du tableau de style snake_case en camelCase
            $key = str_replace('_', '', ucwords($key, '_'));

            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }


    public function __toString()
    {
        return $this->getNomPhoto() . "";
    }

    public function getIdPhoto()
    {
        return $this->_id_photo;
    }

    public function getNomPhoto()
    {
        return $this->_nom_photo;
    }

    public function getTaillePixelsX() // Ajustement du nom de la méthode
    {
        return $this->_taille_pixels_x;
    }

    public function getTaillePixelsY() // Ajustement du nom de la méthode
    {
        return $this->_taille_pixels_y;
    }

    public function getPoids()
    {
        return $this->_poids;
    }

    public function getNbrDePhoto()
    {
        return $this->_nbrdephoto;
    }

    public function getLien()
    {
        return $this->_lien;
    }

    public function getPrix()
    {
        return $this->_prix;
    }

    public function getDescription()
    {
        return $this->_description;
    }




    // Setters
    public function setIdphoto($id_photo)
    {
        $this->_id_photo = $id_photo;
    }

    public function setNomphoto($nom_photo)
    {
        $this->_nom_photo = $nom_photo;
    }
    public function setNbrDePhoto($nbrdephoto)
    {
        $this->_nbrdephoto = $nbrdephoto;
    }

    public function setTaillePixelsX($taillepxx) // Ajustement du nom de la méthode
    {
        $this->_taille_pixels_x = $taillepxx;
    }

    public function setTaillePixelsY($taillepxy) // Ajustement du nom de la méthode
    {
        $this->_taille_pixels_y = $taillepxy;
    }

    public function setPoids($poids)
    {
        $this->_poids = $poids;
    }

    public function setLien($lien)
    {
        $this->_lien = $lien;
    }

    public function setPrix($prix)
    {
        $this->_prix = $prix;
    }

    public function setDescription($desc)
    {
        $this->_description = $desc;
    }

}
?>
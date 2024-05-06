<?php
class Panier
{
    private $_id_panier;
    private $_id_photo;
    private $_id_user;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getter pour l'id_panier
    public function getIdPanier()
    {
        return $this->_id_panier;
    }

    // Setter pour l'id_panier
    public function setIdPanier($id_panier)
    {
        $this->_id_panier = $id_panier;
    }

    // Getter pour l'id_photo
    public function getIdPhoto()
    {
        return $this->_id_photo;
    }

    // Setter pour l'id_photo
    public function setIdPhoto($id_photo)
    {
        $this->_id_photo = $id_photo;
    }

    // Getter pour l'id_user
    public function getIdUser()
    {
        return $this->_id_user;
    }

    // Setter pour l'id_user
    public function setIdUser($id_user)
    {
        $this->_id_user = $id_user;
    }
}

?>
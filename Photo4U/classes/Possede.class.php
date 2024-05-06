<?php
class Possede
{
    private $_id_user;
    private $_id_photo;

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

    public function getIdUser()
    {
        return $this->_id_user;
    }

    public function setIdUser($id_user)
    {
        $this->_id_user = $id_user;
    }

    public function getIdPhoto()
    {
        return $this->_id_photo;
    }

    public function setIdPhoto($id_photo)
    {
        $this->_id_photo = $id_photo;
    }
}
?>
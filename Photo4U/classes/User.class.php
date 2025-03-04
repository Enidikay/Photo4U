<?php
class User
{
	// Attributs
	private $_id_user;
	private $_nom;
	private $_prenom;
	private $_type;
	private $_mail;
	private $_mdp;
	private $_credit;
	private $_pdp;


	public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}

	// Dans votre classe User, dans la méthode hydrate
	public function hydrate(array $donnees)
	{
		foreach ($donnees as $key => $value) {
			$method = 'set' . ucfirst($key);

			if (method_exists($this, $method)) {
				// Assurez-vous que l'ID est correctement assigné
				if ($key === 'id_user') {
					$this->setId($value); // Utilisez la méthode setId pour assigner l'ID
				} else {
					$this->$method($value);
				}
			}
		}
	}

	// Getters

	public function getId()
	{
		return $this->_id_user;
	}

	public function getNom()
	{
		return $this->_nom;
	}

	public function getPrenom()
	{
		return $this->_prenom;
	}

	public function getMail()
	{
		return $this->_mail;
	}

	public function getType()
	{
		return $this->_type;
	}

	public function getCredit()
	{
		return $this->_credit;
	}

	public function getMdp()
	{
		return $this->_mdp;
	}

	public function getPdp()
	{
		return $this->_pdp;
	}
	// Setters

	public function setId($id)
	{
		$id = (int) $id;
		if ($id > 0) {
			$this->_id_user = $id; 
		}
	}

	public function setCredit($credit)
	{
		$credit = (int) $credit;
		$this->_credit = $credit;
	}

	public function setNom($nom)
	{
		if (is_string($nom)) {
			$this->_nom = $nom;
		}
	}

	public function setPrenom($prenom)
	{
		if (is_string($prenom)) {
			$this->_prenom = $prenom;
		}
	}

	public function setType($type)
	{
		if (is_string($type)) {
			$this->_type = $type;
		}
	}

	public function setMail($mail)
	{
		$this->_mail = $mail;
	}

	public function setMdp($mdp)
	{
		$this->_mdp = $mdp;
	}

	public function setPdp($pdp)
	{
		$this->_pdp = $pdp;
	}
}
?>
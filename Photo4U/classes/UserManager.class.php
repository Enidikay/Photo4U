<?php
class UserManager
{
	private $_db;

	public function __construct($db)
	{
		$this->setDB($db);
	}

	public function add(User $user)
	{
		try {
			// Vérifier si l'utilisateur existe déjà
			$existingUser = $this->getUser($user->getMail());
			if ($existingUser) {
				// Afficher un message d'erreur approprié
				throw new Exception("L'utilisateur avec cette adresse e-mail existe déjà.");
			}

			// Insérer l'utilisateur dans la base de données
			$q = $this->_db->prepare('INSERT INTO users(nom,prenom,type,mail,mdp) VALUES(:nom, :prenom, :type, :mail, :mdp)');
			$q->bindValue(':nom', $user->getNom());
			$q->bindValue(':prenom', $user->getPrenom());
			$q->bindValue(':type', $user->getType());
			$q->bindValue(':mail', $user->getMail());
			$q->bindValue(':mdp', md5($user->getMdp()));

			$q->execute();

			$user->hydrate([
				'Id' => $this->_db->lastInsertId(),
				'Credit' => 0
			]);
		} catch (Exception $e) {
			// Capturer et gérer l'exception
			echo "Erreur lors de l'ajout de l'utilisateur : " . $e->getMessage();
		}
	}



	public function login(User $user)
	{
		try {
			$q = $this->_db->prepare("SELECT * FROM users WHERE Mail = :mail");
			$q->bindValue(":mail", $user->getMail());
			$q->execute();

			$result = $q->fetch(PDO::FETCH_ASSOC);

			if ($result && $result['Mdp'] === md5($user->getMdp())) {
				$_SESSION['id'] = $result['id_user'];
				$_SESSION['nom'] = $result['Nom'];
				$_SESSION['prenom'] = $result['Prenom'];
				$_SESSION['mail'] = $result['Mail'];
				$_SESSION['photo'] = $result['Photo'];
				$_SESSION['credit'] = $result['Credit'];
				$_SESSION['type'] = $result['Type'];
				return $result; // Retourner les informations de l'utilisateur sous forme de tableau associatif
			} else {
				return false; // Retourner false si les identifiants sont incorrects
			}
		} catch (PDOException $e) {
			// Gérer les erreurs PDO
			echo "Erreur de connexion : " . $e->getMessage();
			return false; // Retourner false en cas d'erreur de connexion
		}
	}


	public function GetInformationsbyid($id)
	{
		try {
			$query = 'SELECT * FROM users WHERE id_user = :id';
			$stmt = $this->_db->prepare($query);
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
			$stmt->execute();
			$userInfo = $stmt->fetch(PDO::FETCH_ASSOC);
			return $userInfo;
		} catch (PDOException $e) {
			// Gérer les erreurs PDO
			echo "Erreur : " . $e->getMessage();
			return false; // Retourner false en cas d'erreur
		}
	}


	public function update(User $user)
	{
		try {
			$query = "UPDATE users 
                  SET nom = :nom, prenom = :prenom, mail = :mail, photo = :photo 
                  WHERE id_user = :id";

			$stmt = $this->_db->prepare($query);
			$stmt->bindValue(':nom', $user->getNom());
			$stmt->bindValue(':prenom', $user->getPrenom());
			$stmt->bindValue(':mail', $user->getMail());
			$stmt->bindValue(':photo', $user->getPdp());
			$stmt->bindValue(':id', $user->getId());

			$stmt->execute();

			return true; // La mise à jour s'est déroulée avec succès
		} catch (PDOException $e) {
			// Gérer les erreurs de mise à jour ici
			error_log('Erreur lors de la mise à jour de l\'utilisateur: ' . $e->getMessage());
			return false; // La mise à jour a échoué
		}
	}




	public function getUser($iduser)
	{
		$q = $this->_db->prepare('SELECT * FROM users WHERE id_user = :id');
		$q->bindValue(':id', $iduser);
		$q->execute();
		$userInfo = $q->fetch(PDO::FETCH_ASSOC);
		return $userInfo;
	}

	public function delete($id)
	{
		$q = $this->_db->prepare('DELETE FROM users WHERE id_user = :id');
		$q->bindValue(':id', $id);

		return $q->execute();
	}


	public function getUserPhotoById($id)
	{
		$query = 'SELECT Photo FROM users WHERE id_user = :id';
		$q = $this->_db->prepare($query);
		$q->bindValue(':id', $id);

		if ($q->execute()) {
			$result = $q->fetch(PDO::FETCH_ASSOC);
			return $result['Photo']; // Retourne le chemin de l'image de profil
		} else {
			return false;
		}
	}

	public function menuuser($type)
	{
		try {
			$query = 'SELECT * FROM menu WHERE Habilitation LIKE :type';
			$q = $this->_db->prepare($query);
			$q->bindValue(':type', "%" . $type . "%");

			if ($q->execute()) {
				$result = $q->fetchAll(PDO::FETCH_ASSOC);
				return $result;
			} else {
				return false;
			}
		} catch (PDOException $e) {
			echo "Erreur PDO : " . $e->getMessage();
			return false;
		}
	}


	public function ajoutCredits($userId, $credits)
	{
		try {
			$query = "UPDATE users SET credit = credit + :credits WHERE id_user = :userId";
			$stmt = $this->_db->prepare($query);
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
			$stmt->bindParam(':credits', $credits, PDO::PARAM_INT);
			$stmt->execute();

			if ($stmt->rowCount() > 0) {
				return true; // Mise à jour réussie
			} else {
				return false; // Mise à jour échouée (aucune ligne affectée)
			}
		} catch (PDOException $e) {
			return false; // Retourner false pour indiquer que l'opération a échoué
		}
	}


	public function updateCredits($userId, $newCredits)
	{
		try {
			// Préparez la requête SQL pour mettre à jour les crédits de l'utilisateur
			$query = "UPDATE users SET credit = :credits WHERE id_user = :userId";
			$stmt = $this->_db->prepare($query);
			$stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
			$stmt->bindParam(':credits', $newCredits, PDO::PARAM_INT);

			// Exécutez la requête
			$stmt->execute();

			// Vérifiez si la mise à jour a réussi
			if ($stmt->rowCount() > 0) {
				return true; // Mise à jour réussie
			} else {
				return false; // Aucune ligne mise à jour
			}
		} catch (PDOException $e) {
			// Gérez les exceptions PDO
			// Vous pouvez logger l'erreur, afficher un message d'erreur, etc.
			return false; // Mise à jour échouée
		}
	}

	public function count()
	{
		return $this->_db->query("SELECT COUNT(*) FROM users")->fetchColumn();
	}

	public function exists($mailUser, $mdpUser)
	{
		$q = $this->_db->prepare('SELECT COUNT(*) FROM users WHERE mail = :mail AND mdp = :mdp');
		$q->execute([':mail' => $mailUser, ':mdp' => $mdpUser]);
		return (bool) $q->fetchColumn();
	}

	public function setDb(PDO $db)
	{
		$this->_db = $db;
	}

}
?>
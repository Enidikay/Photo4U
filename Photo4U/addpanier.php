<?php
include ('include/header.inc.php');
include ('include/navbar.php');
// Initialiser le message d'erreur à vide
$error_message = "";
$success_message = "";

if ($_SESSION['type'] === 'photographe') {
    // Rediriger l'utilisateur vers le menu
    header("Location: index.php");
    exit(); // Assurez-vous de terminer l'exécution du script après la redirection
}

if (isset($_SESSION['id'])) {
    // Vérifier si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Vérifier si l'ID de la photo est défini dans le formulaire
        if (isset($_POST["id_photo"])) {
            // Récupérer et convertir l'ID de la photo en entier
            $photo_id = intval($_POST["id_photo"]);

            // Vérifier si la conversion a réussi
            if ($photo_id != 0) {
                // Récupérer l'ID de l'utilisateur depuis la session
                $user_id = $_SESSION['id']; // Utiliser $_SESSION['id']

                // Créer une instance de PanierManager
                $panierManager = new PanierManager($db); // Remplacez $db par votre instance de connexion PDO

                // Récupérer tous les articles actuellement dans le panier de l'utilisateur
                $paniers = $panierManager->getAllPanier();

                // Vérifier si la photo est déjà présente dans le panier de l'utilisateur
                $photoExistsInPanier = false;
                foreach ($paniers as $panier) {
                    if ($panier['id_panier'] == $photo_id && $panier['id_user'] == $user_id) {
                        $photoExistsInPanier = true;
                        break;
                    }
                }

                if ($photoExistsInPanier) {
                    // Message d'erreur si la photo existe déjà dans le panier de l'utilisateur
                    $error_message = "Cette photo est déjà dans votre panier.";
                } else {
                    // Créer un nouvel objet Panier avec l'ID de la photo et l'ID de l'utilisateur
                    $panier = new Panier([
                        'IdPhoto' => $photo_id,
                        'IdUser' => $user_id
                    ]);

                    // Appeler la méthode pour ajouter le produit au panier
                    $panierManager->addPanier($panier);

                    // Message de succès
                    $success_message = "Le produit a été ajouté au panier avec succès.";

                    // Redirection vers la page details_photo.php avec l'ID de la photo en question après l'ajout au panier
                    header("Location: details_photo.php?id=$photo_id");
                    exit; // Assurez-vous de terminer le script après la redirection
                }
            } else {
                // Message d'erreur si la conversion a échoué
                $error_message = "L'ID de la photo est invalide.";
            }
        } else {
            // Message d'erreur si l'ID de la photo n'est pas défini
            $error_message = "L'ID de la photo n'est pas défini.";
        }
    } else {
        // Message d'erreur si le formulaire n'a pas été soumis
        $error_message = "Une erreur s'est produite lors de la soumission du formulaire.";
    }
} else {
    // Message d'erreur si l'utilisateur n'est pas connecté
    $error_message = "Vous devez être connecté pour ajouter un produit au panier.";
}

// Redirection vers la page initiale en cas d'erreur
if (!empty($error_message)) {
    // Redirection vers la page details_photo.php avec l'ID de la photo en question après l'ajout au panier
    header("Location: details_photo.php?id=$photo_id");
    exit; // Assurez-vous de terminer le script après la redirection
}

// Affichage du message de succès ou d'erreur ici
?>
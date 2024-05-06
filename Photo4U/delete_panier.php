<?php
include ('include/header.inc.php');// Inclure votre fichier PanierManager.php ici

// Vérifie si l'ID du panier est défini dans la requête POST
if(isset($_POST['id_panier'])) {
    // Récupérer l'ID du panier à supprimer
    $id_panier = $_POST['id_panier'];

    // Initialisez une instance de PanierManager
    $panierManager = new PanierManager($db); // Assurez-vous que $db est votre objet PDO

    // Supprimer le panier en utilisant la méthode deletePanier
    $panierManager->deletePanier($id_panier);

    // Rediriger vers la page du panier ou une autre page de votre choix
    header('Location: panier.php');
    exit(); // Assurez-vous de terminer le script après la redirection
}
?>

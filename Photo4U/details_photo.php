<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* Styles CSS pour le conteneur de notification */
        #notification-container {
            /* Position fixe en bas à droite */
            position: fixed;
            bottom: 0;
            right: 0;
            /* Marge et remplissage pour l'espacement */
            margin: 8px;
            padding: 16px;
            /* Arrière-plan, couleur du texte, bord arrondi et ombre */
            background-color: #FF4136;
            color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            /* Initialiser la visibilité à cachée */
            display: none;
        }
    </style>
</head>

<body class="h-screen">
    <?php
    include ('include/header.inc.php');
    include ('include/navbar.php'); ?>

    <?php

    // Vérifier si l'ID de la photo est passé dans l'URL
    if (isset($_GET['id'])) {
        // Récupérer l'ID de la photo depuis l'URL
        $photo_id = $_GET['id'];
        // Utiliser la classe Photo pour récupérer les détails de la photo en fonction de son ID
        $photoManager = new PhotoManager($db); // Initialisez le gestionnaire de photos avec la connexion à la base de données
        $photo = $photoManager->getPhotoById($photo_id); // Remplacez cette ligne par votre méthode pour récupérer les détails de la photo par son ID
    
        // Vérifier si la photo existe
        if ($photo) {
            // Check if the photo is in stock
            if ($photo->getNbrDePhoto() > 0) {
                // If in stock, display the photo card
                echo '<div class="container mx-auto px-4 my-8 h-screen flex items-center justify-center">';
                echo '  <div class="w-full max-w-4xl bg-white rounded-xl shadow-lg overflow-hidden">';
                echo '    <div class="md:flex">';
                echo '      <div class="md:flex-shrink-0">';
                echo '        <img src="' . $photo->getLien() . '" alt="' . $photo->getNomPhoto() . '" class="h-96 w-full object-cover md:h-full shadow-lg md:w-96 modal-image">';
                echo '      </div>';
                echo '      <div class="p-8 flex flex-col justify-between">';
                echo '        <div>';
                echo '          <div class="uppercase tracking-wide text-xl text-indigo-500 font-semibold">' . $photo->getNomPhoto() . '</div>';
                echo '          <p class="mt-2 text-gray-500">' . $photo->getDescription() . '</p>';
                echo '          <div class="flex items-center mt-4">';
                echo '            <p class="text-lg font-bold">Stock: </p>';
                echo '            <p class="ml-2">' . $photo->getNbrDePhoto() . '</p>';
                echo '          </div>';
                echo '          <div class="flex items-center mt-2">';
                echo '            <p class="text-lg font-bold">Prix: </p>';
                echo '            <p class="ml-2">' . $photo->getPrix() . ' Credits</p>';
                echo '          </div>';
                echo '          <div class="mt-4">';
                if (isset($_SESSION['id'])) {
                    echo '              <form action="addpanier.php" method="post" onsubmit="showNotification()">';
                    echo '                  <input type="hidden" name="id_photo" value="' . $photo_id . '">';
                    echo '                  <button type="submit" class="cardbutton p-1.5 rounded-md bg-blue-700 text-white p-2">Ajouter au panier</button>';
                    echo '              </form>';
                }
                echo '          </div>';
                echo '        </div>';
                echo '      </div>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
            } else {
                // Afficher un message si la photo n'est plus disponible
                echo '<p>Cette photo n\'est plus disponible</p>';
            }
        } else {
            // Afficher un message si la photo n'existe pas
            echo "Photo not trouvée.";
        }
    } else {
        // Rediriger vers une page la page photo si l'ID de la photo n'est pas fourni dans l'URL
        header("Location: photo.php");
        exit;
    }
    ?>

    <?php include ('include/footer.php'); ?>

    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="imageModal">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white">
                    <img src="" id="fullImage" class="" alt="Image en taille réelle">
                </div>
                <div class="mt-4 flex justify-center items-center">
                    <div>
                        <p class="text-lg font-bold">Caractéristiques de la photo :</p>
                        <p>Dimensions : <?php echo $photo->getTaillePixelsX() . ' x ' . $photo->getTaillePixelsY(); ?>
                            pixels</p>
                        <p>Poids : <?php echo $photo->getPoids() . ' Ko'; ?></p>
                    </div>
                </div>

                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                        id="closeModal">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Récupération de l'élément de l'image
        const image = document.querySelector('.modal-image');

        // Récupération de l'élément de l'image dans le modal
        const fullImage = document.getElementById('fullImage');

        // Ajout d'un écouteur d'événement pour afficher le modal lorsque l'image est cliquée
        image.addEventListener('click', () => {
            // Récupération de l'URL de l'image
            const imageUrl = image.getAttribute('src');
            // Attribution de l'URL de l'image au modal
            fullImage.setAttribute('src', imageUrl);
            // Affichage du modal
            const modal = document.getElementById('imageModal');
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        });

        // Ajout d'un écouteur d'événement pour fermer le modal lorsque le bouton de fermeture est cliqué
        const closeModalButton = document.getElementById('closeModal');
        closeModalButton.addEventListener('click', () => {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        });
    </script>

</body>

</html>
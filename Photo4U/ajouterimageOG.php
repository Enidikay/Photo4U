<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <title>Document</title>
</head>

<body>
    <?php
    include ('include/header.inc.php');
    include ('include/navbar.php');
    ?>
    <div class="flex justify-center items-center h-screen pt-10">
        <form action="#" method="POST" enctype="multipart/form-data"
            class="max-w-md mx-auto p-4 bg-white shadow-md rounded-md" onsubmit="return validateForm()">
            <div class="mb-4">
                <label for="nom" class="block text-gray-700 font-bold mb-2">Nom :</label>
                <input type="text" name="nom" id="nom" class="border border-gray-300 p-2 rounded-md">
            </div>
            <div class="mb-4">
                <label for="nombre" class="block text-gray-700 font-bold mb-2">Nombre de photos :</label>
                <input type="number" name="nombre" id="nombre" class="border border-gray-300 p-2 rounded-md">
            </div>
            <div class="mb-4">
                <label for="prix" class="block text-gray-700 font-bold mb-2">Prix :</label>
                <input type="number" name="prix" id="prix" class="border border-gray-300 p-2 rounded-md">
            </div>
            <div class="mb-4">
                <label for="photo" class="block text-gray-700 font-bold mb-2">Sélectionnez une photo :</label>
                <input type="file" name="photo" id="photo" class="border border-gray-300 p-2 rounded-md"
                    onchange="previewPhoto(event)">
            </div>
            <div class="mb-4">
                <img id="preview" class="w-32 h-32 mx-auto mb-2 rounded-md" alt="Aperçu de la photo" />
            </div>
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Envoyer</button>
            </div>
        </form>
        <script>
            function previewPhoto(event) {
                const file = event.target.files[0];
                const reader = new FileReader();

                reader.onload = function (e) {
                    const previewElement = document.getElementById("preview");
                    previewElement.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }

            function validateForm() {
                const nom = document.getElementById("nom").value;
                const nombre = document.getElementById("nombre").value;
                const photo = document.getElementById("photo").value;

                if (nom === "" || nombre === "" || photo === "") {
                    alert("Veuillez remplir tous les champs.");
                    return false;
                }

                return true;
            }
        </script>
    </div>
    <?php
    include ('connection.inc.php');

    // Vérification si le formulaire a été soumis
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Récupération des informations du fichier
        $nom = $_POST['nom']; // Récupération de la valeur du champ "nom"
        $nombre = $_POST['nombre']; // Récupération de la valeur du champ "nombre"
        $prix = $_POST['prix']; // Récupération de la valeur du champ "prix"
        $nom_photo = $_FILES['photo']['name']; // Récupération du nom du fichier
        $dimensions = getimagesize($_FILES['photo']['tmp_name']);
        $taillepx_x = $dimensions[0];
        $taillepx_y = $dimensions[1];
        $poids = $_FILES['photo']['size'];
        $upload_folder = "images/photosuser/";
        $upload_file = $upload_folder . basename($nom_photo);

        // Vérification des valeurs avec var_dump()
        echo 'Nomphoto : ' . $nom . "<br />";
        echo 'nombre : ' . $nombre . "<br />";
        echo 'TaillepxX : ' . $taillepx_x . "<br />";
        echo 'TaillepxY : ' . $taillepx_y . "<br />";
        echo 'Poids : ' . $poids . "<br />";
        echo 'Lien : ' . $upload_file . "<br />";
        echo 'Prix : ' . $prix . "<br />";

        // Déplacement du fichier téléchargé vers le dossier d'upload
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $upload_file)) {

            try {
                // Création d'une instance de PhotoManager
                $photoManager = new PhotoManager($db);

                // Création d'un objet Photo
                $photo = new Photo([
                    'Nomphoto' => $nom,
                    'TaillepxX' => $taillepx_x,
                    'TaillepxY' => $taillepx_y,
                    'NombreDePhotos' => $nombre,
                    'Poids' => $poids,
                    'Lien' => $upload_file,
                    'Prix' => $prix // Ajout du champ "prix"
                ]);

                print ($photo);
                // Ajout de la photo à la base de données
                $photoManager->addPhoto($photo);
                echo "L'image a été uploadée avec succès.";
                echo ("<br/>");
                echo 'Nom de la photo : ' . $photo->getNomPhoto() . "<br />";
                echo 'Taille x : ' . $photo->getTaillepxX() . "<br />";
                echo 'Taille y : ' . $photo->getTaillepxY() . "<br />";
                echo 'Poids : ' . $photo->getPoids() . "<br />";
                echo 'Lien : ' . $photo->getLien() . "<br />";
                echo 'Prix : ' . $photo->getPrix() . "<br />";
            } catch (PDOException $e) {
                echo "Erreur: " . $e->getMessage();
            }
        } else {
            echo "Erreur lors de l'upload de l'image.";
        }
    }
    ?>
    <?php
    include ('include/footer.php');
    ?>
</body>

</html>
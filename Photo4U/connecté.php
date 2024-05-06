<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body style="background: url('images/bridge-5356471_1920.jpg') no-repeat; background-size: cover; background-position: center;">
    <?php
    include ('include/header.inc.php');
    include ('include/navbar.php');

    $userManager = new UserManager($db);

    // Récupérer l'ID de l'utilisateur depuis la session
    $userId = $_SESSION['id'];

    // Récupérer les informations de l'utilisateur connecté
    $userInfo = $userManager->getUser($userId);
    ?>

    <div class="flex justify-center items-center h-screen" style="padding: 90px 40px; backdrop-filter: blur(10px);">
        <div
            class="bg-gray-200 p-8 rounded-lg shadow-lg w-1/3 h-2/3 flex flex-col justify-center items-center shadow-xl">
            <h1 class="text-2xl font-bold mb-4">Vous êtes connecté !</h1>
            <p class="text-gray-700">En tant que
                <?php echo $userInfo['Type']; ?>
            </p>
            <p class="text-gray-700">Bienvenue sur notre site
                <?php echo $userInfo['Nom']; ?>
            </p>
            <a href="index.php"
                class="px-4 py-2 bg-white text-black rounded-full hover:bg-gray-300 mt-4 transition duration-300 ease-in-out">Retour
                à l'accueil</a>
        </div>
    </div>

    <?php
    include ('include/footer.php');
    ?>
</body>

</html>
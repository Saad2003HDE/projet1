<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    nav {
        background-color: #007BFF;
        color: #fff;
        padding: 10px;
        text-align: center;
    }

    main {
        max-width: 800px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px 30px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    .buttons-container {
        text-align: center;
        margin-top: 20px; /* Réduire l'espace en haut des boutons */
    }

    .btn {
        margin: 10px;
        padding: 10px 20px;
        background-color: #007BFF;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
        display: inline-block; /* Pour que les boutons soient alignés horizontalement */
    }

    .btn:hover {
        background-color: #0056b3;
    }

    footer {
        background-color: #333;
        color: #fff;
        padding: 10px;
        text-align: center;
    }
</style>


</head>
<body>
<div class="buttons-container">
    <a href="login.php" class="btn">Se Connecter</a>
    <a href="register.php" class="btn">S'inscrire</a>
    <!-- <a href="accueil_client.php" class="btn">accueil_client</a> -->
</div>

</body>
</html>

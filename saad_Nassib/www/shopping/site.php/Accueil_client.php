<?php
// Inclure le fichier de configuration contenant la connexion à la base de données
include("config.php");

// Démarrer la session pour gérer les informations de l'utilisateur connecté
session_start();

// Vérifier si l'utilisateur n'est pas connecté, le rediriger vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérer le nom d'utilisateur depuis la session
$user_name = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #111;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .dashboard-container {
            max-width: 800px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #007BFF;
        }

        p {
            color: #555;
            margin-bottom: 20px;
        }

        .dashboard-links {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .dashboard-link {
            margin: 10px;
            padding: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .dashboard-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Contenu du tableau de bord -->
<div class="dashboard-container">
    <h2>Bienvenue sur Koora <?php echo $user_name; ?></h2>
    <p>Accédez à toutes les fonctionnalités possibles</p>

    <!-- Liens vers d'autres pages du site -->
    <div class="dashboard-links">
        <a class="dashboard-link" href="Accueil_liste_produit.php"> site de vente</a>
        <a class="dashboard-link" href="Liste_command_client.php">Mes commandes en cours</a>
        <a class="dashboard-link" href="Modifier_profil.php">Modifier mon profil</a>
        <a class="dashboard-link" href="Suprimer_mon_compte.php">Supprimer mon compte</a>
        <a class="dashboard-link" href="Logout_client.php">Se déconnecter</a>
    </div>
</div>

</body>
</html>

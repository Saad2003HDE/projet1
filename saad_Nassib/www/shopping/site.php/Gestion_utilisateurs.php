<?php
session_start();
/ Replace these values with your actual database credentials
$db_host = 'localhost';
$db_user = 'root';
$db_password = '';
$db_name = 'ecom1_project';
// Create a connection to the database
$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check the connection
if (!$conn) {
    die("Erreur de connexion à la base de données: " . mysqli_connect_error());
}


include('config.php');
if (!isset($_SESSION["user_id"])) {
    header('Location: login.php');
    exit; // Arrêter l'exécution après la redirection
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Afficher les utilisateurs</title>
    <style>
         body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        header {
            background-color: #343a40;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        nav {
            background-color: #007bff;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 10px;
        }

        main {
            margin: 20px;
            text-align: center;
        }

        p {
            background-color: #ffffff;
            border: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            background-color: #007bff;
            color: #ffffff;
            border-radius: 4px;
            transition: background-color 0.3s;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <h1>User Management</h1>
    </header>

    <nav>
        <a href="Accueil_admin.php">Retour à l'Accueil</a>
    </nav>

    <main>
        <!-- Afficher les utilisateurs -->
        <?php
        // Récupération du rôle de l'utilisateur en cours
        $user_id = $_SESSION['user_id'];

        // Connexion à la base de données MySQLi
        $link = mysqli_connect("localhost", "root", "", "ecom1_project");

        if (!$link) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Préparation de la requête avec MySQLi
        $recupUserRole = mysqli_prepare($link, 'SELECT role_id FROM user WHERE id = ?');
        mysqli_stmt_bind_param($recupUserRole, "i", $user_id);
        mysqli_stmt_execute($recupUserRole);
        mysqli_stmt_bind_result($recupUserRole, $userRole);
        mysqli_stmt_fetch($recupUserRole);
        mysqli_stmt_close($recupUserRole);

        // Initialisation de la variable pour éviter une erreur si $recupUtilisateurs n'est pas défini
        $recupUtilisateurs = null;

        // Si l'utilisateur est un admin (role_id = 2)
        if ($userRole == 2) {
            // Récupération des utilisateurs avec un rôle de client (role_id = 3)
            $recupUtilisateurs = mysqli_query($link, 'SELECT * FROM user WHERE role_id = 1');
            // Si l'utilisateur est un super admin (role_id = 1)
        } else if ($userRole == 3) {
            // Récupération de tous les utilisateurs (role_id = 2 et 3)
            $recupUtilisateurs = mysqli_query($link, 'SELECT * FROM user WHERE role_id != 3');
        }

        if ($recupUtilisateurs && mysqli_num_rows($recupUtilisateurs) > 0) {
            while ($utilisateur = mysqli_fetch_assoc($recupUtilisateurs)) {
        ?>
            <p>
                Username: <?= htmlspecialchars($utilisateur["user_name"], ENT_QUOTES, 'UTF-8'); ?>
                <br>
                Role: <?= $utilisateur["role_id"] == 2 ? 'Admin' : 'Client'; ?>
                <br>
                <a href="Supprimer_utilisateur.php?id=<?= htmlspecialchars($utilisateur['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Supprimer l'utilisateur</a>
                <br>
                <a href="Change_statut_utilisateur.php?id=<?= htmlspecialchars($utilisateur['id'], ENT_QUOTES, 'UTF-8'); ?>" class="btn btn-primary">Change_statut_utilisateur</a>
            </p>
        <?php
            }
        } else {
            echo 'Aucun utilisateur à gérer!';
        }

        // Fermer la connexion MySQLi
        mysqli_close($link);
        ?>
    </main>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

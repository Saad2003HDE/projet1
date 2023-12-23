<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil administrateur</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            color: #111;
        }

        header {
            background-color: #232f3e;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        nav {
            display: flex;
            justify-content: space-around;
            background-color: #131921;
            padding: 10px;
            border-bottom: 1px solid #ffffff;
        }

        nav a {
            text-decoration: none;
            color: #ffffff;
            padding: 10px 20px;
            font-size: 16px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #ff9900;
        }

        main {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- En-tête de la page -->
    <header>
        <h1>Accueil administrateur</h1>
    </header>

    <!-- Barre de navigation avec des liens vers différentes pages d'administration -->
    <nav>
        <a href="Gestion_utilisateurs.php">Gérer utilisateurs</a>
        <a href="Gestion_produit.php">Gérer les produits</a>
        <a href="publier-produit.php">Ajouter un nouveau produit</a>
        <a href="Liste_command_admin.php" id="orders">Consulter les commandes en cours</a>
        <a href="Logout_Admin.php">Se déconnecter</a>
    </nav>

    <!-- Contenu principal de la page -->
    <main>
        <!-- Ajoutez ici le contenu spécifique à votre page -->
    </main>
</body>
</html>

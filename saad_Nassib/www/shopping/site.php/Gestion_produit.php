<?php
// Démarre la session PHP
session_start();

// Inclut le fichier de configuration qui contient la connexion à la base de données
include('config.php');

// Dossier où sont stockées les images des produits
$dossierImageProduit = "Image_produit/";

// Redirige vers la page de connexion si l'utilisateur n'est pas connecté
if(!$_SESSION['user_id']){
    header('Location: login.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <!-- Bouton pour retourner à la page d'accueil de l'administrateur -->
    <title>Afficher tous les produits</title>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .produit {
            max-width: 300px;
            background-color: #fff;
            padding: 20px;
            margin: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        p {
            color: #555;
        }

        img {
            max-width: 90%;
            height: auto;
            margin-bottom: 10px;
        }

        /* Boutons */
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        .delete-button, .edit-button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .delete-button {
            background-color: #DC3545; /* Couleur rouge pour le bouton de suppression */
            color: white;
        }

        .edit-button {
            background-color: #007BFF; /* Couleur bleue pour le bouton de modification */
            color: white;
        }

        .delete-button:hover, .edit-button:hover {
            opacity: 0.8;
        }

        /* Bouton de retour */
        .home-button {
            background-color: #4CAF50; /* Couleur verte */
            color: white;
            margin-right: 10px; /* Marge de droite pour déplacer le bouton vers la droite */
            margin-top: 10px; /* Marge en haut pour plus d'espace */
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .home-button:hover {
            background-color: #45a049; /* Couleur verte légèrement plus sombre au survol */
        }
    </style>
</head>
<body>
    <?php
        // Récupère tous les produits de la base de données
        $recupProduit = $pdo->query('SELECT * FROM product');
        while($produit = $recupProduit->fetch()){
            ?>
            <div class="produit">
                <h1><?= $produit['name']; ?></h1>
                <p><?= $produit['description']; ?></p>
                <p><?= $produit['quantity']; ?></p>
                <p><?= $produit['price']; ?></p>
                <img src="<?= $dossierImageProduit . $produit['img_url']; ?>" alt="Image du produit">
                
                <!-- Boutons pour supprimer et modifier le produit -->
                <div class="button-container">
                    <a href="supprimer-produit.php?id=<?= $produit['id']; ?>">
                        <button class="delete-button">Supprimer produit</button>
                    </a>
                    <a href="Modifier_produit.php?id=<?= $produit['id']; ?>">
                        <button class="edit-button">Modifier produit</button>
                    </a>
                </div>
            </div>
            <?php
        }
    ?>
    
    <!-- Bouton "Retour à l'accueil" -->
    <a href="Accueil_admin.php">
        <button class="home-button">Retour à l'accueil</button>
    </a>
</body>
</html>
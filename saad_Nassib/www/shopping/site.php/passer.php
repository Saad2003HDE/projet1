<?php
// passer.php

session_start();
include('config.php');

if (isset($_POST['idorder']) && isset($_POST['idproduct']) && isset($_POST['quantity'])) {
    $order_id = htmlspecialchars($_POST['idorder']);
    $product_id = htmlspecialchars($_POST['idproduct']);
    $quantity = htmlspecialchars($_POST['quantity']);

    // Connexion à la base de données
    $dbConnection = mysqli_connect("hostname", "username", "password", "database");

    // Vérification de la connexion
    if (!$dbConnection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Ajoutez la commande dans la table des commandes
    $insertOrder = mysqli_prepare($dbConnection, "INSERT INTO order_has_product (order_id, product_id, quantity) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($insertOrder, 'iii', $order_id, $product_id, $quantity);
    mysqli_stmt_execute($insertOrder);

    // Fermeture de la connexion
    mysqli_close($dbConnection);

    // Mettez à jour la quantité du produit dans la table des produits si nécessaire

    // Redirigez l'utilisateur vers une page de confirmation ou une autre page appropriée
    echo "Commande ajoutée avec succès";
} else {
    // Si le formulaire n'est pas soumis, redirigez l'utilisateur vers une page appropriée
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande</title>
</head>
<body>  
    <form method="POST" action="passer.php">
        <!-- Ajoutez les champs pour les informations de commande -->
        <label for="idorder">Order ID:</label>
        <input type="text" name="idorder" required>

        <label for="idproduct">Product ID:</label>
        <input type="text" name="idproduct" required>

        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" required>

        <!-- Ajoutez d'autres champs si nécessaire -->

        <br>
        <br>

        <br>
        <br>
        <button type="submit" class="btn btn-sm btn-success" name="buy">Commander</button>
    </form>
</body>
</html>

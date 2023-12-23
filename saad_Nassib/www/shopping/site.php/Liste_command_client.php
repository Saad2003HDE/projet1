<?php
include("config.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Get the user ID
$user_id = $_SESSION['user_id'];

// Fetch orders for the current user
$fetchOrders = $pdo->prepare('SELECT * FROM user_order WHERE user_id = ?');
$fetchOrders->execute([$user_id]);

// Check if orders were found
if ($fetchOrders->rowCount() > 0) {
    $orders = $fetchOrders->fetchAll(PDO::FETCH_ASSOC);

    // Display the orders
    echo '<h2>Liste des commandes en cours :</h2>';
    echo '<ul>';
    foreach ($orders as $order) {
        echo '<li>';
        echo 'ID de la commande : ' . $order['id'] . '<br>';
        echo 'Ref de la commande : ' . $order['ref'] . '<br>';
        echo 'Date de la commande : ' . $order['date'] . '<br>';
        echo 'Total prix de la commande : ' . $order['total'] . '<br>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo 'Aucune commande en cours.';
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commandes en cours</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            margin: 10px 0;
            padding: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            color: #333;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <a href="Accueil_client.php">Retour à la page d'accueil client</a>
</body>
</html>

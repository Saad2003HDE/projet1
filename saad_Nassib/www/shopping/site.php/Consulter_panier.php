<?php
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
session_start();

// Vérifiez si l'utilisateur est connecté
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Sélectionnez les produits associés à l'`order_id` de l'utilisateur connecté
    $sql = "SELECT o.order_id as order_id, p.id as product_id, p.name, p.price, p.description, o.quantity, o.quantity * p.price as total_price_produit
            FROM order_has_product as o
            INNER JOIN product as p ON o.product_id = p.id
            WHERE o.order_id = ?";

    $stmt = mysqli_prepare($connection, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    $cartItems = mysqli_fetch_all($result, MYSQLI_ASSOC);

    // Calculer le total du panier
    $totalCartPrice = 0;
    foreach ($cartItems as $item) {
        $totalCartPrice += $item['total_price_produit'];
    }
}

// Mettre à jour la quantité du produit dans le panier
if (isset($_POST['update_quantity'])) {
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['new_quantity'];

    $updateSql = "UPDATE order_has_product SET quantity = ? WHERE order_id = ? AND product_id = ?";
    $updateStmt = mysqli_prepare($connection, $updateSql);
    mysqli_stmt_bind_param($updateStmt, "iii", $new_quantity, $order_id, $product_id);
    mysqli_stmt_execute($updateStmt);

    // Rediriger pour éviter la soumission multiple du formulaire
    header('Location: Consulter_panier.php');
    exit();
}

// Supprimer un produit du panier
if (isset($_POST['delete_product'])) {
    $order_id = $_POST['order_id'];
    $product_id = $_POST['product_id'];

    $deleteSql = "DELETE FROM order_has_product WHERE order_id = ? AND product_id = ?";
    $deleteStmt = mysqli_prepare($connection, $deleteSql);
    mysqli_stmt_bind_param($deleteStmt, "ii", $order_id, $product_id);
    mysqli_stmt_execute($deleteStmt);

    // Rediriger pour éviter la soumission multiple du formulaire
    header('Location: Consulter_panier.php');
    exit();
}

// Vider complètement le panier
if (isset($_POST['clear_cart'])) {
    $clearSql = "DELETE FROM order_has_product WHERE order_id = ?";
    $clearStmt = mysqli_prepare($connection, $clearSql);
    mysqli_stmt_bind_param($clearStmt, "i", $user_id);
    mysqli_stmt_execute($clearStmt);

    // Rediriger pour éviter la soumission multiple du formulaire
    header('Location: Consulter_panier.php');
    exit();
}
?>



<?php
session_start();

// Replace these values with your actual database credentials
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


// Include your database configuration
include("config.php");

// Initialize variables
$orders = [];
$errorMessage = "";

// Check if the database connection is successful
if ($conn) {
    // Fetch ongoing orders
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $searchTerm = '%' . $_GET['search'] . '%';

        // Use the existing connection $conn
        $fetchOrders = mysqli_prepare($conn, 'SELECT * FROM user_order WHERE ref LIKE ?');
        mysqli_stmt_bind_param($fetchOrders, 's', $searchTerm);
        mysqli_stmt_execute($fetchOrders);

        // Check if orders were found
        $fetchOrdersResult = mysqli_stmt_get_result($fetchOrders);
        if ($fetchOrdersResult) {
            $orders = mysqli_fetch_all($fetchOrdersResult, MYSQLI_ASSOC);
        } else {
            $errorMessage = "Error fetching orders: " . mysqli_error($conn);
        }
    } else {
        // Use the existing connection $conn
        $fetchOrders = mysqli_query($conn, 'SELECT * FROM user_order');

        // Check if orders were found
        if ($fetchOrders) {
            $orders = mysqli_fetch_all($fetchOrders, MYSQLI_ASSOC);
        } else {
            $errorMessage = "Error fetching orders: " . mysqli_error($conn);
        }
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    $errorMessage = "Erreur de connexion à la base de données";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ongoing Orders</title>
    <meta charset="utf-8">
    <style>
    body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

h2 {
    color: #333;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

.search-form {
    margin-top: 20px;
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    color: #555;
}

input[type="text"] {
    width: 200px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

button {
    padding: 8px 16px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #0056b3;
}

.back-button {
    display: inline-block;
    background-color: #ccc;
    color: #333;
    padding: 10px 20px;
    text-decoration: none;
    border-radius: 4px;
    margin-top: 10px;
}

.error-message {
    color: red;
    margin-bottom: 10px;
}
</style>
</head>
<body>
    <h2>Ongoing Orders</h2>

    <!-- Search Form -->
    <form method="GET" class="search-form">
        <label for="search">Search by Reference:</label>
        <input type="text" name="search" id="search" placeholder="Enter reference">
        <button type="submit">Search</button>
    </form>

    <?php if ($errorMessage): ?>
        <p>Error: <?= $errorMessage ?></p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Reference</th>
                    <th>Date</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= $order['id'] ?></td>
                        <td><?= $order['ref'] ?></td>
                        <td><?= $order['date'] ?></td>
                        <td><?= $order['total'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <!-- Back button to return to admin home page -->
    <a href="Accueil_admin.php" class="back-button">Retour</a>
</body>
</html>

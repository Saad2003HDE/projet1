<?php
include('config.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];

    // Create a connection (replace these with your actual database credentials)
    $connection = mysqli_connect("localhost", "root", "", "ecom1_project");

    // Check the connection
    if (!$connection) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Use mysqli_query for executing queries
    $recupProduit = mysqli_query($connection, "SELECT * FROM product WHERE id = '$getid'");

    // Use mysqli_num_rows
    if (mysqli_num_rows($recupProduit) > 0) {
        $deleteProduit = mysqli_query($connection, "DELETE FROM product WHERE id = '$getid'");

        header('Location: Gestion_produit.php');
    } else {
        echo "Aucun produit trouvé";
    }

    // Close the connection
    mysqli_close($connection);
} else {
    echo "Aucun identifiant trouvé";
}
?>

<?php
session_start();

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Traitement de l'ajout au panier
if (isset($_POST['buy'])) {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Ajouter le produit avec la quantité au panier
    $_SESSION['cart'][$productId] = $quantity;
}

// Connexion à la base de données avec MySQLi
$servername = "localhost";
$username = "root";
$password = "";
$database = "ecom1_project";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

$produits = mysqli_query($conn, "SELECT * FROM product");

?>

<!DOCTYPE html>
<html lang="en">     
<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container-fluid {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .product-container {
            border: 1px solid #ddd;
            background-color: #fff;
            margin: 10px;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
            width: 100%;
        }

        .product-container:hover {
            transform: scale(1.05);
        }

        .product-container img {
            max-width: 100%;
            height: auto;
            margin-bottom: 10px;
        }

        .quantity-select {
            width: 50px;
            padding: 5px;
        }

        .cart-container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <?php
        while ($produit = mysqli_fetch_assoc($produits)) {
            ?>
            <!-- Afficher ici les informations du produit -->
            <div class="col-md-4">
                <form method="POST" action="accueil.php">
                    <div class="product-container">
                        <h4>ID: <?php echo $produit['id']; ?></h4>
                        <p>Name: <?php echo $produit['name']; ?></p>
                        <p>Price: <?php echo $produit['price']; ?></p>
                        <p>Description: <?php echo $produit['description']; ?></p>
                        <!-- Afficher l'image du produit -->
                        <img src="../upload/produit/<?= $produit['img_url'] ?>" alt="Image du produit">
                        <br> <br>
                        <!-- Ajoutez d'autres informations du produit ici -->

                        <!-- Ajoutez le champ de sélection pour la quantité -->
                        <label for="quantity">Quantity:</label>
                        <select name="quantity" class="quantity-select">
                            <?php
                            // Vous pouvez ajuster la limite de la quantité en fonction de vos besoins
                            for ($i = 1; $i <= 10; $i++) {
                                echo "<option value=\"$i\">$i</option>";
                            }
                            ?>
                        </select>

                        <!-- Ajoutez un champ caché pour transmettre l'ID du produit -->
                        <input type="hidden" name="product_id" value="<?php echo $produit['id']; ?>">

                        <!-- Ajoutez le bouton pour acheter -->
                        <input type="submit" name="buy" value="Ajouter au panier" class="btn btn-primary">
                    </div>
                </form>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
if (!empty($_SESSION['cart'])) {
    // Récupérer les IDs des produits dans le panier
    $productIds = array_keys($_SESSION['cart']);
    
    // Construire une chaîne d'IDs pour la requête SQL
    $productIdsString = implode(',', $productIds);

    // Exécuter une seule requête pour récupérer tous les produits du panier
    $result = mysqli_query($conn, "SELECT * FROM product WHERE id IN ($productIdsString)");

    // Vérifier si la requête a réussi
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $productId = $row['id'];
            $quantity = $_SESSION['cart'][$productId];
            ?>
            <div>
                <h4>ID: <?php echo $productId; ?></h4>
                <p>Name: <?php echo $row['name']; ?></p>
                <p>Price: <?php echo $row['price']; ?></p>
                <p>Quantity: <?php echo $quantity; ?></p>
            </div>
            <?php
        }
    } else {
        echo "<p>Une erreur s'est produite lors de la récupération des produits du panier.</p>";
    }
} else {
    echo "<p>Votre panier est vide.</p>";
}
?>
</div>

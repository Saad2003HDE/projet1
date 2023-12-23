<?php
session_start();

// Redirige si l'utilisateur n'est pas connecté
if (!$_SESSION['user_id']) {
    header('Location: login.php');
    exit;
}

$dossierImageProduit = "Image_produit/";
$successMessage = $errorMessage = "";

if (isset($_POST['envoi'])) {
    if (!empty($_POST['name']) && !empty($_POST['quantity']) && !empty($_POST['price']) && !empty($_POST['description'])) {
        $name = htmlspecialchars($_POST['name']);
        $quantity = intval($_POST['quantity']);
        $price = floatval($_POST['price']);
        $description = nl2br(htmlspecialchars($_POST["description"]));

        $filename = "";
        if (!empty($_FILES['img_url']['name'])) {
            $img_url = $_FILES['img_url']['name'];
            $filename = uniqid() . $img_url;
            move_uploaded_file($_FILES['img_url']['tmp_name'], $dossierImageProduit . $filename);
        }

        // Remplacez les informations de connexion ci-dessous
        $db_host = 'localhost';
        $db_user = 'root';
        $db_password = '';
        $db_name = 'ecom1_project';

        $conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

        if (!$conn) {
            die("Erreur de connexion à la base de données: " . mysqli_connect_error());
        }

        $insererProduit = mysqli_prepare($conn, 'INSERT INTO product(name, quantity, price, img_url, description) VALUES(?, ?, ?, ?, ?)');
        mysqli_stmt_bind_param($insererProduit, 'sidss', $name, $quantity, $price, $filename, $description);
        mysqli_stmt_execute($insererProduit);

        $successMessage = "Le produit a bien été ajouté";

        // Fermer la connexion
        mysqli_close($conn);
    } else {
        $errorMessage = "Veuillez compléter tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un produit</title>
    <style>
       body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007BFF;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
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

        .message {
            color: green;
            margin-bottom: 10px;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <form method="POST" action="" enctype="multipart/form-data">
            <h2>Ajouter un produit</h2>

            <?php if ($errorMessage): ?>
                <div class="error-message"><?= $errorMessage ?></div>
            <?php endif; ?>

            <?php if ($successMessage): ?>
                <div class="message"><?= $successMessage ?></div>
            <?php endif; ?>

            <label for="name">Nom du produit :</label>
            <input type="text" name="name" required>

            <label for="quantity">Quantité :</label>
            <input type="number" name="quantity" required>

            <label for="price">Prix :</label>
            <input type="text" name="price" required>

            <label class="form-label">Image</label>
            <input type="file" class="form-control" name="img_url">

            <label for="description">Description :</label>
            <textarea name="description" required></textarea>

            <input type="submit" name="envoi" value="Ajouter le produit">
        </form>

        <a href="Accueil_admin.php" class="back-button">Retour</a>
    </div>
</body>
</html>

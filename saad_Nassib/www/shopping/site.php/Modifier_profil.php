<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "ecom1_project";

// Créez la connexion
$conn = mysqli_connect($servername, $username, $password, $database);

// Vérifiez la connexion
if (!$conn) {
    die("La connexion à la base de données a échoué : " . mysqli_connect_error());
}

include('config.php');

// Vérifiez si l'utilisateur est connecté
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Récupérez l'ID de l'utilisateur connecté
$user_id = $_SESSION['user_id'];

// Récupérez les informations de l'utilisateur à partir de la base de données
$recupUser = mysqli_prepare($conn, 'SELECT * FROM user WHERE id = ?');
mysqli_stmt_bind_param($recupUser, 'i', $user_id);
mysqli_stmt_execute($recupUser);
$resultUser = mysqli_stmt_get_result($recupUser);

if ($resultUser && mysqli_num_rows($resultUser) > 0) {
    $userInfos = mysqli_fetch_assoc($resultUser);
    $first_name = $userInfos['fname'];
    $lname = $userInfos['lname'];
    $email = $userInfos['email'];

    // Fetch billing address
    $billingAddressStmt = mysqli_prepare($conn, 'SELECT * FROM address WHERE id = ?');
    mysqli_stmt_bind_param($billingAddressStmt, 'i', $userInfos['billing_address_id']);
    mysqli_stmt_execute($billingAddressStmt);
    $billingAddressResult = mysqli_stmt_get_result($billingAddressStmt);
    $billingAddress = ($billingAddressResult && mysqli_num_rows($billingAddressResult) > 0) ? mysqli_fetch_assoc($billingAddressResult) : null;

    // Fetch shipment address
    $shipmentAddressStmt = mysqli_prepare($conn, 'SELECT * FROM address WHERE id = ?');
    mysqli_stmt_bind_param($shipmentAddressStmt, 'i', $userInfos['shipping_address_id']);
    mysqli_stmt_execute($shipmentAddressStmt);
    $shipmentAddressResult = mysqli_stmt_get_result($shipmentAddressStmt);
    $shipmentAddress = ($shipmentAddressResult && mysqli_num_rows($shipmentAddressResult) > 0) ? mysqli_fetch_assoc($shipmentAddressResult) : null;

    if (isset($_POST['valider'])) {
        // Récupérez les données du formulaire
        $first_name_saisi = htmlspecialchars($_POST['first_name']);
        $lname_saisi = htmlspecialchars($_POST['last_name']);
        $pwd_saisi = htmlspecialchars($_POST['password']);
        $email_saisi = htmlspecialchars($_POST['email']);
        
        // Mettez à jour les informations de l'utilisateur dans la base de données, le mot est modifié si le champ n'est pas vide
        if (!empty($pwd_saisi)) {
            $pwd_saisi_hash = password_hash($pwd_saisi, PASSWORD_DEFAULT);
            $updateUser = mysqli_prepare($conn, 'UPDATE user SET fname = ?, pwd = ?, email = ?, lname = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateUser, 'ssssi', $first_name_saisi, $pwd_saisi_hash, $email_saisi, $lname_saisi, $user_id);
            mysqli_stmt_execute($updateUser);
        } else {
            $updateUser = mysqli_prepare($conn, 'UPDATE user SET fname = ?, email = ?, lname = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateUser, 'sssi', $first_name_saisi, $email_saisi, $lname_saisi, $user_id);
            mysqli_stmt_execute($updateUser);
        }

        // Vérifier si l'adresse de facturation existe
        if (!empty($_POST['payment_street_nb']) && !empty($_POST['payment_street_name']) && !empty($_POST['payment_city']) && !empty($_POST['payment_province']) && !empty($_POST['payment_zip_code']) && !empty($_POST['payment_country'])) {
            $paymentStreetNb = htmlspecialchars($_POST['payment_street_nb']);
            $paymentStreetName = htmlspecialchars($_POST['payment_street_name']);
            $paymentCity = htmlspecialchars($_POST['payment_city']);
            $paymentProvince = htmlspecialchars($_POST['payment_province']);
            $paymentZipCode = htmlspecialchars($_POST['payment_zip_code']);
            $paymentCountry = htmlspecialchars($_POST['payment_country']);

            $insertBillingAddress = mysqli_prepare($conn, 'INSERT INTO address (street_nb, street_name, city, province, zip_code, country) VALUES (?, ?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($insertBillingAddress, 'ssssss', $paymentStreetNb, $paymentStreetName, $paymentCity, $paymentProvince, $paymentZipCode, $paymentCountry);
            mysqli_stmt_execute($insertBillingAddress);

            // Récupérez l'ID de l'adresse de facturation nouvellement insérée
            $billingAddressId = mysqli_insert_id($conn);

            // Mettez à jour l'ID de l'adresse de facturation dans la table utilisateur
            $updateUserBillingAddressId = mysqli_prepare($conn, 'UPDATE user SET billing_address_id = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateUserBillingAddressId, 'ii', $billingAddressId, $user_id);
            mysqli_stmt_execute($updateUserBillingAddressId);
        }

        // Faites de même pour l'adresse de livraison
        if ($shipmentAddressResult && mysqli_num_rows($shipmentAddressResult) > 0) {
            // Mettez à jour l'adresse de livraison dans la base de données
            $updateShipmentAddress = mysqli_prepare($conn, 'UPDATE address SET street_nb = ?, street_name = ?, city = ?, province = ?, zip_code = ?, country = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateShipmentAddress, 'ssssssi', 
                htmlspecialchars($_POST['delivery_street_nb']),
                htmlspecialchars($_POST['delivery_street_name']),
                htmlspecialchars($_POST['delivery_city']),
                htmlspecialchars($_POST['delivery_province']),
                htmlspecialchars($_POST['delivery_zip_code']),
                htmlspecialchars($_POST['delivery_country']),
                $shipmentAddress['id']
            );
            mysqli_stmt_execute($updateShipmentAddress);
        } else {
            // Insérez une nouvelle adresse de livraison dans la base de données
            $insertShipmentAddress = mysqli_prepare($conn, 'INSERT INTO address (street_nb, street_name, city, province, zip_code, country) VALUES (?, ?, ?, ?, ?, ?)');
            mysqli_stmt_bind_param($insertShipmentAddress, 'ssssss',
                htmlspecialchars($_POST['delivery_street_nb']),
                htmlspecialchars($_POST['delivery_street_name']),
                htmlspecialchars($_POST['delivery_city']),
                htmlspecialchars($_POST['delivery_province']),
                htmlspecialchars($_POST['delivery_zip_code']),
                htmlspecialchars($_POST['delivery_country'])
            );
            mysqli_stmt_execute($insertShipmentAddress);

            // Récupérez l'ID de l'adresse de livraison nouvellement insérée
            $shipmentAddressId = mysqli_insert_id($conn);

            // Mettez à jour l'ID de l'adresse de livraison dans la table utilisateur
            $updateUserShipmentAddressId = mysqli_prepare($conn, 'UPDATE user SET shipping_address_id = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateUserShipmentAddressId, 'ii', $shipmentAddressId, $user_id);
            mysqli_stmt_execute($updateUserShipmentAddressId);
        }

        // Redirigez l'utilisateur vers une page appropriée (par exemple, page de profil)
        header('Location: Accueil_client.php');
        exit;
    }
} else {
    echo "Aucun identifiant utilisateur trouvé";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Modifier Profil</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 800px; /* Adjust the width as needed */
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-gap: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            grid-column: span 4; /* Make the submit button span all four columns */
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <form method="POST" action="">
        <div>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?= isset($first_name) ? $first_name : ''; ?>">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?= isset($lname) ? $lname : ''; ?>">

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?= isset($email) ? $email : ''; ?>">

            <label for="password">Password:</label>
            <input type="password" name="password" value="<?= isset($pwd) ? $pwd : ''; ?>">
        </div>

        <div>
            <!-- Adresse de livraison -->
            <h4>Valider l'adresse de livraison</h4>
            <?php if($shipmentAddressResult && mysqli_num_rows($shipmentAddressResult) > 0){ ?>
                <!-- Les champs du formulaire pour l'adresse de livraison -->
                <label for="delivery_street_nb">Numéro de Rue:</label>
                <input type="text" name="delivery_street_nb" class="form-control" value="<?= $shipmentAddress['street_nb'] ?>" required>
            
                <label for="delivery_street_name">Nom de la Rue:</label>
                <input type="text" name="delivery_street_name" class="form-control" value="<?= $shipmentAddress['street_name'] ?>" required>
            
                <label for="delivery_city">Ville:</label>
                <input type="text" name="delivery_city" class="form-control" value="<?= $shipmentAddress['city'] ?>" required>
            
                <label for="delivery_province">Province:</label>
                <input type="text" name="delivery_province" class="form-control" value="<?= $shipmentAddress['province'] ?>" required>
            
                <label for="delivery_zip_code">Code Postal:</label>
                <input type="text" name="delivery_zip_code" class="form-control" value="<?= $shipmentAddress['zip_code'] ?>" required>
            
                <label for="delivery_country">Pays:</label>
                <input type="text" name="delivery_country" class="form-control" value="<?= $shipmentAddress['country'] ?>" required>
            <?php } ?>
        </div> 

        <div>
            <!-- Adresse de paiement -->
            <h4>Valider l'adresse de paiement</h4>
            <?php if($billingAddressResult && mysqli_num_rows($billingAddressResult) > 0){ ?>
                <!-- Les champs du formulaire pour l'adresse de paiement -->
                <label for="payment_street_nb">Numéro de Rue:</label>
                <input type="text" name="payment_street_nb" class="form-control" value="<?= $billingAddress['street_nb'] ?>" required>

                <label for="payment_street_name">Nom de la Rue:</label>
                <input type="text" name="payment_street_name" class="form-control" value="<?= $billingAddress['street_name'] ?>" required>
            
                <label for="payment_city">Ville:</label>
                <input type="text" name="payment_city" class="form-control" value="<?= $billingAddress['city'] ?>" required>
            
                <label for="payment_province">Province:</label>
                <input type="text" name="payment_province" class="form-control" value="<?= $billingAddress['province'] ?>" required>
            
                <label for="payment_zip_code">Code Postal:</label>
                <input type="text" name="payment_zip_code" class="form-control" value="<?= $billingAddress['zip_code'] ?>" required>

                <label for="payment_country">Pays:</label>
                <input type="text" name="payment_country" class="form-control" value="<?= $billingAddress['country'] ?>" required>
            <?php }   else { ?>
                <label for="payment_street_nb">Numéro de Rue:</label>
                <input type="text" name="payment_street_nb" class="form-control" value="<?= isset($billingAddress['street_nb']) ? $billingAddress['street_nb'] : ''; ?>" required>

                <label for="payment_street_name">Nom de la Rue:</label>
                <input type="text" name="payment_street_name" class="form-control" value="<?= isset($billingAddress['street_name']) ? $billingAddress['street_name'] : ''; ?>" required>

                <label for="payment_city">Ville:</label>
                <input type="text" name="payment_city" class="form-control" value="<?= isset($billingAddress['city']) ? $billingAddress['city'] : ''; ?>" required>

                <label for="payment_pro<vince">Province:</label>
                <input type="text" name="payment_province" class="form-control" value="<?= isset($billingAddress['province']) ? $billingAddress['province'] : ''; ?>" required>

            <label for="payment_zip_code">Code Postal:</label>
            <input type="text" name="payment_zip_code" class="form-control" value="<?= isset($billingAddress['zip_code']) ? $billingAddress['zip_code'] : ''; ?>" required>

            <label for="payment_country">Pays:</label>
            <input type="text" name="payment_country" class="form-control" value="<?= isset($billingAddress['country']) ? $billingAddress['country'] : ''; ?>" required>
        <?php } ?>
        </div>

        <input type="submit" name="valider" value="Submit">
    </form>
</body>
</html>


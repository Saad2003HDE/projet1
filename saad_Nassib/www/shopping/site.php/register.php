<?php


// Assuming your database credentials are defined like this
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "ecom1_project";

// Create a connection
$connection = mysqli_connect($db_host, $db_user, $db_password, $db_name);

// Check the connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}



include("config.php");

$registration_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validation du mot de passe
    if ($password !== $confirm_password) {
        $registration_message = 'Les mots de passe ne correspondent pas. Veuillez réessayer.';
    } else {
        // Hashage du mot de passe
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insertion de l'utilisateur dans la base de données (utilisation de l'ancienne API MySQL)
        $insertUserQuery = "INSERT INTO user (email, user_name, pwd, role_id) VALUES (?, ?, ?, 1)";

        // Use prepared statements to prevent SQL injection
        $stmt = mysqli_prepare($connection, $insertUserQuery);
        mysqli_stmt_bind_param($stmt, "sss", $email, $username, $hashed_password);
        $insertUserResult = mysqli_stmt_execute($stmt);

        if ($insertUserResult) {
            $registration_message = 'Inscription réussie. Connectez-vous maintenant.';
            header("Location: login.php");
            exit;
        } else {
            $registration_message = 'Erreur lors de l\'inscription. Veuillez réessayer.';
        }

        // Close the statement
        mysqli_stmt_close($stmt);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <!-- Your existing styles remain unchanged -->
</head>
<body>
    <style>
body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #111;
        }

        header {
            background-color: #131a22;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .registration-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px 30px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            margin-top: 0;
            color: #111;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        p {
            color: red;
            font-weight: bold;
        }

        .buttons-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn {
            margin: 10px;
            padding: 10px 20px;
            background-color: #4caf50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: inline-block;
        }

        .btn:hover {
            background-color: #45a049;
        }

        footer {
            background-color: #131a22;
            color: #fff;
            padding: 10px;
            text-align: center;
        }
    </style>

<div class="registration-container">
    <h2>Inscription</h2>

    <?php if (!empty($registration_message)): ?>
        <p style="color:green"><?= $registration_message ?></p>
    <?php endif; ?>

    <form action="register.php" method="post">
        <div>
            <label for="email">Adresse e-mail :</label>
            <input type="text" id="email" name="email">
        </div>

        <div>
            <label for="username">Nom d'utilisateur :</label>
            <input type="text" id="username" name="username">
        </div>

        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password">
        </div>

        <div>
            <label for="confirm_password">Confirmer le mot de passe :</label>
            <input type="password" id="confirm_password" name="confirm_password">
        </div>

        <div>
            <input type="submit" value="S'inscrire">
        </div>
        <br>
        <div>
            <span>Déjà un compte? <a href="login.php">Connectez-vous ici</a>.</span>
        </div>

    </form>
</div>

</body>
</html>

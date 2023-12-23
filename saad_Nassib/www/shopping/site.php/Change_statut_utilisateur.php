<?php
include('config.php');

$role_id = null; // Initialize $role_id

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];

    $recupUser = mysqli_prepare($connection, 'SELECT * FROM user WHERE id = ?');
    mysqli_stmt_bind_param($recupUser, 'i', $getid);
    mysqli_stmt_execute($recupUser);
    $result = mysqli_stmt_get_result($recupUser);

    if (mysqli_num_rows($result) > 0) {
        $userInfo = mysqli_fetch_assoc($result);
        $role_id = $userInfo['role_id'];

        if (isset($_POST['valider'])) {
            $role_id_saisi = htmlspecialchars($_POST['role_id']);

            $updateUser = mysqli_prepare($connection, 'UPDATE user SET role_id = ? WHERE id = ?');
            mysqli_stmt_bind_param($updateUser, 'ii', $role_id_saisi, $getid);
            mysqli_stmt_execute($updateUser);

            header('Location: Gestion_utilisateurs.php');
            exit;
        } else {
            echo "Aucun utilisateur trouvé";
        }
    } else {
        echo "Aucun identifiant trouvé";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier le rôle de l'utilisateur</title>
    <meta charset="utf-8">
    <style>
        /* Vos styles CSS ici */
    </style>
</head>
<body>
    <form method="POST" action="">
        <label for="role_id">Rôle de l'utilisateur:</label>
        <select name="role_id">
            <option value="2" <?php echo ($role_id == 2) ? 'selected' : ''; ?>>Admin</option>
            <option value="3" <?php echo ($role_id == 1) ? 'selected' : ''; ?>>Client</option>
        </select>

        <br><br>
        <input type="submit" name="valider">
    </form>

    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
</body>
</html>

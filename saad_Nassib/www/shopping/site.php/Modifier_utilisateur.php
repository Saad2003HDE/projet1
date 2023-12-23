<?php
session_start();
include('co.php'); // Assurez-vous d'inclure votre fichier de connexion

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];

    // Établir la connexion
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ecom1_project";

    $conn = mysqli_connect($servername, $username, $password, $database);

    // Vérifier la connexion
    if (!$conn) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Récupérer l'utilisateur
    $recupUser = mysqli_prepare($conn, 'SELECT * FROM user WHERE id = ?');
    mysqli_stmt_bind_param($recupUser, 'i', $getid);
    mysqli_stmt_execute($recupUser);
    $result = mysqli_stmt_get_result($recupUser);

    if ($result && mysqli_num_rows($result) > 0) {
        // Supprimer l'utilisateur
        $supprimerUser = mysqli_prepare($conn, 'DELETE FROM user WHERE id = ?');
        mysqli_stmt_bind_param($supprimerUser, 'i', $getid);
        mysqli_stmt_execute($supprimerUser);

        // Rediriger après la suppression
        header('Location: Gestion_utilisateurs.php');
        exit;
    } else {
        echo "Aucun utilisateur n'a été trouvé";
    }

    // Fermer la connexion
    mysqli_close($conn);
} else {
    echo "L'identifiant n'a pas été récupéré";
}
?>

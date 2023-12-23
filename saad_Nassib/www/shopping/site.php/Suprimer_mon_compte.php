<?php
include("config.php");

// Assurez-vous que la session est démarrée.
session_start();

// Vérifiez si l'utilisateur est connecté
if(isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];

    // Utilisez la même connexion pour la requête SELECT
    $recupUser = mysql_query("SELECT * FROM user WHERE id = '$userId'");

    if (mysql_num_rows($recupUser) > 0) {
        // Utilisez également la même connexion pour la requête DELETE
        $supprimerUser = mysql_query("DELETE FROM user WHERE id = '$userId'");

        // Ajoutez ici d'autres actions après la suppression si nécessaire.

        // Déconnectez l'utilisateur après la suppression
        session_destroy();

        echo "Utilisateur supprimé avec succès";
        
        // Rediriger vers la page de connexion.
        header('Location: login.php');
        exit;
    } else {
        echo "Aucun utilisateur n'a été trouvé";
    }
} else {
    echo "Utilisateur non connecté";
}
?>

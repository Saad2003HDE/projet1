<?php
session_start();
include('config.php');

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $getid = $_GET['id'];

    $recupUser = mysql_query("SELECT * FROM user WHERE id = '$getid'");

    if (mysql_num_rows($recupUser) > 0) {
        $supprimerUser = mysql_query("DELETE FROM user WHERE id = '$getid'");

        header('Location: Gestion_utilisateurs.php');
        exit; // Arrêter l'exécution après la redirection
    } else {
        echo "Aucun membre n'a été trouvé";
    }
} else {
    echo "L'identifiant n'a pas été récupéré";
}
?>

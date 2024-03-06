<?php

require_once '../../vendor/autoload.php'; 

use App\Page;

$page = new Page();

// Vérifiez si la méthode de requête est POST et si les données utilisateur nécessaires sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {

    // Récupérez l'ID de l'utilisateur à supprimer
    $user_id = $_POST['user_id'];

    // Appelez une méthode pour supprimer l'utilisateur de la base de données
    $page->deleteUser($user_id);

    // Redirigez vers la page users.php après la suppression
    header("location: users.php");
    exit();
}

// Si aucun formulaire n'a été soumis ou si les données utilisateur nécessaires ne sont pas présentes, redirigez vers la page users.php
header("location: users.php");
exit();
?>

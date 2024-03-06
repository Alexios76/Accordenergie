<?php

require_once '../../vendor/autoload.php'; 

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['user_type'])) {

    if ($page->session->get('user_type') === 'admin') {
        $pdo = $page->getPdo();
     
        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type'];

        $sql_update = "UPDATE user SET user_type = :user_type WHERE user_id = :user_id";

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute(['user_type' => $user_type, 'user_id' => $user_id]);
    } else {
        echo "Vous n'êtes pas autorisé à effectuer cette action."; // Message si l'utilisateur n'est pas un administrateur
        exit; // Arrête l'exécution du script
    }
}


$users = $page->getAllUsers();


echo $page->render('admin/users/list.html.twig', [
    'users' => $users
]);


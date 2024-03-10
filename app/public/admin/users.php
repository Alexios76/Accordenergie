<?php
require_once '../../vendor/autoload.php'; 
use App\Page;

$page = new Page();

// Démarrez la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si un message flash est défini
if (isset($_SESSION['flash_message'])) {
    // Affichez le message flash avec la classe de style appropriée
    echo '<div class="alert alert-' . $_SESSION['flash_type'] . '">' . $_SESSION['flash_message'] . '</div>';

    // Supprimez le message flash pour qu'il ne soit affiché qu'une seule fois
    unset($_SESSION['flash_message']);
    unset($_SESSION['flash_type']);
}

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

<?php

require_once '../../vendor/autoload.php'; 

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {

    $user_id = $_GET['id'];

    $pdo = $page->getPdo();

    $sql_select = "SELECT * FROM user WHERE user_id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$user_id]);
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        // Gérer le cas où aucun utilisateur avec cet ID n'est trouvé
        echo "Utilisateur non trouvé";
        exit;
    }

    echo $page->render('admin/users/list_detail.html.twig', ['user' => $user]);
} else {
    // Gérer le cas où aucun ID d'utilisateur n'est fourni dans la requête
    echo "ID d'utilisateur non fourni";
    exit;
}

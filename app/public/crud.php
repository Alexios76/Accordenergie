<?php

require_once '../vendor/autoload.php'; 

use App\Page;

$page = new Page();
$page->session->get('user');

// Suppression d'intervention
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intervention_id'])) {
    $intervention_id = $_POST['intervention_id'];

    $pdo = $page->getPdo();
    $sql_delete = "DELETE FROM intervention WHERE intervention_id = ?";
    $stmt_delete = $pdo->prepare($sql_delete);
    $stmt_delete->execute([$intervention_id]);

    // Message flash
    $_SESSION['flash_message'] = "L'intervention a été supprimée avec succès.";
    $_SESSION['flash_type'] = "success";

    // Redirection vers la page interventions.php
    header("Location: interventions.php");
    exit();
}
 elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['phone_number'])) {
    // Mise à jour des données utilisateur
    $user_id = $_POST['user_id'];

    $pdo = $page->getPdo();
    $sql_select = "SELECT * FROM user WHERE user_id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$user_id]);
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Utilisateur non trouvé";
        exit;
    }

    $data = [
        'email' => $_POST['email'],
        'name' => $_POST['name'],
        'surname' => $_POST['surname'],
        'phone_number' => $_POST['phone_number'],
        'user_id' => $user_id
    ];

    $sql_update = "UPDATE user SET email = :email,  name = :name, surname = :surname, phone_number = :phone_number WHERE user_id = :user_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute($data);

    // Affichage de la page de mise à jour
    echo $page->render('standardiste/users/update_intervention.html.twig', [
        'user_id' => $user_id,
        'connected' => $page->session->isConnected(),
        'user_type' => 'admin'
    ]);
    exit;
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Affichage des détails d'utilisateur
    $user_id = $_GET['id'];

    $pdo = $page->getPdo();

    $sql_select = "SELECT * FROM user WHERE user_id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$user_id]);
    $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        echo "Utilisateur non trouvé";
        exit;
    }

    // Affichage de la page de détails de l'utilisateur
    echo $page->render('standardiste/users/read_intervention.html.twig', [
        'user' => $user,
        'connected' => $page->session->isConnected(),
        'user_type' => 'standardiste'
    ]);
    exit;
} else {
    echo "Requête non valide";
    exit;
}

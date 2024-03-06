<?php

require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {

    $user_id = $_POST['user_id'];

    $pdo = $page->getPdo();

    // Vérifier si l'utilisateur existe dans la base de données
    $user = $page->getUserByEmail(['user_id' => $user_id]);

    if (!$user) {
        // Gérer le cas où aucun utilisateur avec cet ID n'est trouvé
        echo "Utilisateur non trouvé";
        exit;
    }

    // Récupérer les données postées depuis le formulaire
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $user_type = $_POST['user_type'];

    // Mettre à jour les informations de l'utilisateur
    $sql_update = "UPDATE user SET name = :name, surname = :surname, email = :email, phone_number = :phone_number, user_type = :user_type WHERE user_id = :user_id";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute(['name' => $name, 'surname' => $surname, 'email' => $email, 'phone_number' => $phone_number, 'user_type' => $user_type, 'user_id' => $user_id]);

    // Rediriger vers la liste des utilisateurs après la mise à jour
    header("Location: list_update.html.twig");
    exit;
} else {
    // Gérer le cas où les données postées ne sont pas valides
    echo "Données invalides";
    exit;
}

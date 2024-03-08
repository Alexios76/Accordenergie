<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$msg = '';

if (isset($_POST['send'])) {
    $email = $_POST['email'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Vérifier si un utilisateur avec cet e-mail existe
    $user = $page->getUserByEmail(['email' => $email]);

    if (!$user) {
        // Si aucun utilisateur correspondant n'est trouvé, affichez un message d'erreur
        $msg = "L'adresse e-mail n'existe pas dans notre système";
    } else {
        // Vérifiez si le nouveau mot de passe correspond au mot de passe de confirmation
        if ($newPassword !== $confirmPassword) {
            $msg = "Les mots de passe ne correspondent pas";
        } else {
            // Hash du nouveau mot de passe
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Mise à jour du mot de passe dans la base de données
            $success = $page->updateUserPassword(['email' => $email, 'password' => $hashedPassword]);

            if ($success) {
                // Définir un message de réussite dans la session
                $_SESSION['success_msg'] = "Mot de passe mis à jour avec succès";
                header('Location: index.php'); // Redirection vers index.php
                exit(); // Assurer que le script s'arrête d'exécuter après la redirection
            } else {
                $msg = "Échec de la mise à jour du mot de passe";
            }
        }
    }
}

echo $page->render('forgot.html.twig', ['msg' => $msg]);
?>

<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

// Fonction pour afficher un message flash
function flashMessage($message, $type = 'success') {
    $_SESSION['flash_message'] = [
        'message' => $message,
        'type' => $type
    ];
}

// Vérifiez si l'utilisateur est connecté avant d'accéder à ses données
if (!$page->session->isConnected()) {
    // Rediriger vers la page de connexion avec un message d'erreur
    flashMessage("Vous devez être connecté pour accéder à cette page", 'error');
    header("Location: login.php");
    exit;
}

// Obtenez l'identifiant de l'utilisateur à partir de la session
$user_id = $page->session->get('user_id');

// Récupérer les détails de l'utilisateur en fonction de son ID depuis la base de données
$user = $page->getUserById($user_id); // Utilisez getUserById au lieu de getUserByEmail

if (!$user) {
    // Gérer le cas où aucun utilisateur avec cet ID n'est trouvé
    flashMessage("Utilisateur non trouvé", 'error');
    header("Location: update.php"); // Rediriger vers une autre page pour gérer l'erreur
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['phone_number'])) {
        // Mettre à jour les données de l'utilisateur si toutes les données POST requises sont présentes
        $data = [
            'email' => $_POST['email'],
            'name' => $_POST['name'],
            'surname' => $_POST['surname'],
            'phone_number' => $_POST['phone_number'],
            'user_id' => $user_id
        ];

        // Mettez à jour les informations de l'utilisateur
        if ($page->updateUser($data)) {
            // Afficher un message flash si la mise à jour a réussi
            flashMessage("Les informations de l'utilisateur ont été mises à jour avec succès", 'success');
            // Rediriger vers la page profil après la mise à jour
            header("Location: update.php");
            exit;
        } else {
            // Afficher un message flash d'erreur si la mise à jour a échoué
            flashMessage("Erreur lors de la mise à jour des informations de l'utilisateur", 'error');
        }
    }
}

// Récupérer le message flash s'il existe
$flashMessage = isset($_SESSION['flash_message']) ? $_SESSION['flash_message'] : null;
unset($_SESSION['flash_message']); // Supprimer le message flash de la session après l'avoir récupéré

echo $page->render('profil.html.twig', [
    'user' => $user, // Passez $user à la vue pour qu'il soit disponible dans le template Twig
    'connected' => $page->session->isConnected(),
    'user_type' => $page->session->get('user_type'),
    'flash_message' => $flashMessage // Passer le message flash à la vue
]);

?>

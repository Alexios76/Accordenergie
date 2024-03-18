<?php


require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données nécessaires sont fournies
    if (isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['phone_number'], $_POST['user_type'])) {
        // Vérifier si l'email existe déjà dans la base de données
       // Vérifier si l'email existe déjà dans la base de données
        $existingUser = $page->getUserByEmail(['email' => $_POST['email']]);
        if ($existingUser) {
            // Email déjà existant, afficher un message flash
            $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Email existant, veuillez changer.'];

            // Enregistrez les données postées dans la session pour les recharger dans le formulaire
            $_SESSION['form_data'] = $_POST;

            // Rediriger vers la page d'ajout pour afficher le message flash
            header("Location: ".$_SERVER['PHP_SELF']);
            exit;
        } else {
            // Préparer les données pour l'insertion dans la base de données
            $data = [
                'email' => $_POST['email'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'phone_number' => $_POST['phone_number'],
                'user_type' => $_POST['user_type']
            ];

            // Insérer les données dans la base de données
            $page->insert('user', $data);

            // Vider les données du formulaire de session
            unset($_SESSION['form_data']);

            // Rediriger vers la page des utilisateurs après l'ajout
            header("Location: users.php");
            exit;
        }
    } else {
        // Gérer le cas où des données sont manquantes
        $_SESSION['flash_message'] = ['type' => 'error', 'message' => 'Veuillez fournir toutes les informations nécessaires.'];

        // Enregistrez les données postées dans la session pour les recharger dans le formulaire
        $_SESSION['form_data'] = $_POST;

        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }
}

// Récupérer le message flash s'il existe
$flashMessage = $_SESSION['flash_message'] ?? null;

// Supprimer le message flash pour qu'il ne soit pas affiché à nouveau lors de la prochaine requête
unset($_SESSION['flash_message']);

// Vous devez fournir des données à afficher dans le modèle Twig
echo $page->render('admin/users/list_ajout.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => 'admin',
    'flash_message' => $flashMessage, // Passer le message flash au modèle Twig
    'form_data' => $_SESSION['form_data'] ?? [], // Passer les données du formulaire au modèle Twig
]);

?>

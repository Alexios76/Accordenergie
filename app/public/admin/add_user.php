<?php

require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si toutes les données nécessaires sont fournies
    if (isset($_POST['email'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['phone_number'], $_POST['user_type'])) {
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

        // Rediriger vers la page des utilisateurs après l'ajout
        header("Location: users.php");
        exit;
    } else {
        // Gérer le cas où des données sont manquantes
        echo "Veuillez fournir toutes les informations nécessaires.";
    }
}
// Vous devez fournir des données à afficher dans le modèle Twig
echo $page->render('admin/users/list_ajout.html.twig', []);
?>

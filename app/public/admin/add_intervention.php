<?php
require_once '../../vendor/autoload.php'; 
use App\Page;

$page = new Page();

// Récupérer tous les degrés d'urgence
$degre_urgence_list = $page->getAllDegreUrgence();

// Vérifiez si la méthode de requête est POST et si les données d'intervention nécessaires sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $date_intervention = $_POST['date_intervention'];
    $nature_intervention = $_POST['nature_intervention'];
    $description = $_POST['description'];
    $street_and_number = $_POST['street_and_number'];
    $adress_complement = $_POST['adress_complement'];
    $code_postal = $_POST['code_postal'];
    $ville = $_POST['ville'];
    $societe = $_POST['societe'];
    $degre_urgence_id = $_POST['degre_urgence_id'];
    $user_id = $_POST['user_id'];
    $id_standardiste = $_POST['id_standardiste'];
    $id_intervenant = $_POST['id_intervenant'];
    
    // Définir le status_id par défaut
    $status_id_default = 1;

    // Appelez une méthode pour ajouter l'intervention à la base de données
    $page->addIntervention($date_intervention, $nature_intervention, $description, $street_and_number, $adress_complement, $code_postal, $ville, $societe, $degre_urgence_id, $status_id_default, $user_id, $id_standardiste, $id_intervenant);

    // Définissez un message flash de succès
    $_SESSION['flash_message'] = "L'intervention a été ajoutée avec succès.";
    $_SESSION['flash_type'] = "success";

    // Redirigez vers la page interventions.php après l'ajout
    header("location: interventions.php");
    exit();
}

// Récupérer tous les standardistes et les intervenants
$standardistes = $page->getStandardistes();
$intervenants = $page->getIntervenants(); 
// Récupérer tous les clients
$clients = $page->getClients();

echo $page->render('admin/users/add_intervention.html.twig', [
    'standardistes' => $standardistes,
    'intervenants' => $intervenants,
    'clients' => $clients, // Utilisez 'clients' au lieu de 'client'
    'degre_urgence_list' => $degre_urgence_list, // Ajout de la liste des degrés d'urgence
    'connected' => $page->session->isConnected(),
    'user_type' => 'admin'
]);

?>

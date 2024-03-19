<?php
require_once '../../vendor/autoload.php'; 
use App\Page;

$page = new Page();

$user_id = $page->session->get('user_id'); 

if (!$user_id) {
    header('Location: login.php');
    exit();
}

// Récupérer le statut sélectionné (si disponible)
$selectedStatus = isset($_POST['selected_status']) ? $_POST['selected_status'] : null;

// Requête SQL de base pour récupérer toutes les interventions
$sql = "SELECT i.*, u.name AS intervenant_name, u.surname AS intervenant_surname, c.name AS client_name, c.surname AS client_surname, d.type AS degre_urgence_type, s.type AS status_type, i.nature_intervention AS nature_intervention
        FROM intervention i 
        INNER JOIN user u ON i.id_intervenant = u.user_id 
        INNER JOIN degreurgence d ON i.degre_urgence_id = d.degre_urgence_id 
        INNER JOIN statut s ON i.status_id = s.status_id 
        INNER JOIN user c ON i.user_id = c.user_id 
        WHERE c.user_type = 'client'";

// Ajoutez une condition WHERE si un statut est sélectionné
if ($selectedStatus) {
    $sql .= " AND s.type = :selected_status";
}

// Préparez et exécutez la requête SQL
$stmt = $page->pdo->prepare($sql);

// Liaison des paramètres s'il y en a
if ($selectedStatus) {
    $stmt->bindParam(':selected_status', $selectedStatus);
}

$stmt->execute();

// Récupérez les interventions
$interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Now pass the interventions array to the Twig template to render
echo $page->render('admin/users/intervention.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => 'admin', // Suppose que l'utilisateur est un admin pour voir toutes les interventions
    'interventions' => $interventions,
    'selected_status' => $selectedStatus // Passer la valeur sélectionnée au template Twig
]);
?>

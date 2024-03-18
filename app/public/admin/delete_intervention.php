<?php
require_once '../../vendor/autoload.php'; 
use App\Page;

$page = new Page();

// Vérifiez si la méthode de requête est POST et si les données d'intervention nécessaires sont présentes
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intervention_id'])) {

    // Récupérez l'ID de l'intervention à supprimer
    $intervention_id = $_POST['intervention_id'];

    // Appelez une méthode pour supprimer l'intervention de la base de données
    $page->deleteIntervention($intervention_id);

    // Définissez un message flash de succès
    $_SESSION['flash_message'] = "L'intervention a été supprimée avec succès.";
    $_SESSION['flash_type'] = "success";

    // Redirigez vers la page interventions.php après la suppression
    header("location: interventions.php");
    exit();
}

// Si aucun formulaire n'a été soumis ou si les données d'intervention nécessaires ne sont pas présentes, redirigez vers la page interventions.php
header("location: interventions.php");
exit();
?>

<?php
require_once '../vendor/autoload.php'; 

use App\Page;

$page = new Page();
$page->session->get('user');

// Vérification du type de requête HTTP
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification de la suppression d'intervention
    if (isset($_POST['intervention_id'])) {
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
    } elseif (isset($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['phone_number'], $_POST['intervention_id'])) {
        // Mise à jour des données de l'intervention (retirée de cette partie)
        // Redirection vers la page interventions.php
        header("Location: interventions.php");
        exit();
    } else {
        echo "Requête non valide";
        exit();
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Affichage des détails de l'intervention
    $intervention_id = $_GET['id'];

    $pdo = $page->getPdo();

    $sql_select = "SELECT * FROM intervention WHERE intervention_id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$intervention_id]);
    $intervention = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$intervention) {
        echo "Intervention non trouvée";
        exit;
    }

    // Affichage de la page de détails de l'intervention
    echo $page->render('standardiste/users/read_intervention.html.twig', [
        'intervention' => $intervention,
        'connected' => $page->session->isConnected(),
        'user_type' => 'standardiste'
    ]);
    exit;
} else {
    echo "Requête non valide";
    exit;
}
?>

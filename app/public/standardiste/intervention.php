<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$page->session->get('user');

$user_id = $_SESSION['user_id']; // Assuming you've stored user_id in session after login
$conn = $page->getPdo();


$sql = "SELECT * FROM intervention WHERE user_id = ? ORDER BY date_intervention DESC";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $user_id, PDO::PARAM_INT); // Utiliser bindValue pour lier le paramètre
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Envoi des données à la vue TWIG
echo $page->twig->render('intervention_table.html.twig', [
    'interventions' => $result,
    'connected' => $page->session->isConnected(),
    'user_id' => $user_id,
    'user_type' => 'standardiste'

]);
?>


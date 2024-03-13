<?php
require_once '../vendor/autoload.php'; 
use App\Page;

$page = new Page();


$user_id = $page->session->get('user_id'); 


if (!$user_id) {
   
    header('Location: login.php');
    exit();
}

// Query the database for interventions related to the logged-in user
$interventions = [];
try {
    $stmt = $page->pdo->prepare("SELECT i.*, u.name, u.surname FROM intervention i INNER JOIN user u ON i.user_id = u.user_id WHERE i.user_id = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle the exception
    die("Error: " . $e->getMessage());
}

// Now pass the interventions array to the Twig template to render
echo $page->render('my_interventions.html.twig', [
    
    'connected' => $page->session->isConnected(),
    'user_type' => 'client',
    'interventions' => $interventions
    

]);
?>


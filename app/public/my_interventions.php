<?php
require_once '../vendor/autoload.php'; // Adjust the path as needed
use App\Page;

$page = new Page();
$user_id = $page->session->get('user_id'); // Retrieve the logged-in user's ID from the session

// Check if the user is logged in and has a user_id
if (!$user_id) {
    // Redirect to login page if not logged in
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
echo $page->render('my_interventions.html.twig', ['interventions' => $interventions]);
?>

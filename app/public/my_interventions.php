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
    $stmt = $page->pdo->prepare("SELECT 
    i.*, 
    u.name AS intervenant_name, 
    u.surname AS intervenant_surname, 
    c.name AS client_name, 
    c.surname AS client_surname, 
    d.type AS degre_urgence_type, 
    s.type AS status_type 
FROM 
    intervention i 
INNER JOIN 
    user u ON i.id_intervenant = u.user_id 
INNER JOIN 
    degreurgence d ON i.degre_urgence_id = d.degre_urgence_id 
INNER JOIN 
    statut s ON i.status_id = s.status_id 
INNER JOIN 
    user c ON i.user_id = c.user_id 
WHERE 
    i.user_id = :user_id AND c.user_type = 'client'
");
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


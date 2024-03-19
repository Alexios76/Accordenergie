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
} if (!isset($_POST['id']) && !isset($_GET['id'])) {
    die("ID de l'intervention non spécifié.");
}
$intervention_id = isset($_POST['id']) ? $_POST['id'] : $_GET['id'];

// Traiter le formulaire de commentaire s'il est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment'])) {
        $comment = $_POST['comment'];
        
        try {
            // Mettre à jour le commentaire dans la base de données
            $stmt = $page->pdo->prepare("UPDATE intervention SET description = :comment WHERE intervention_id = :id");
            $stmt->bindParam(':id', $intervention_id, PDO::PARAM_INT);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->execute();
            
            // Rediriger vers la page précédente après la mise à jour
            header("Location: read_intervention.php?id=$intervention_id");
            exit();
        } catch (PDOException $e) {
            die("Erreur lors de la mise à jour du commentaire : " . $e->getMessage());
        }
    } else {
        die("Le commentaire n'a pas été spécifié.");
    }
}

// Récupérer les détails de l'intervention depuis la base de données
$intervention = [];
try {
    $stmt = $page->pdo->prepare("SELECT i.*, intervenant.name AS intervenant_name, standardiste.name AS standardiste_name, c.name AS client_name, c.surname AS client_surname, d.type AS degre_urgence_type, s.type AS status_type, i.description 
    FROM intervention i 
    INNER JOIN user AS intervenant ON i.id_intervenant = intervenant.user_id 
    INNER JOIN user AS standardiste ON i.id_standardiste = standardiste.user_id 
    INNER JOIN degreurgence d ON i.degre_urgence_id = d.degre_urgence_id 
    INNER JOIN statut s ON i.status_id = s.status_id 
    INNER JOIN user c ON i.user_id = c.user_id 
    WHERE c.user_type = 'client' AND i.intervention_id = :id");
    $stmt->bindParam(':id', $intervention_id, PDO::PARAM_INT);
    $stmt->execute();   
    $intervention = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des détails de l'intervention : " . $e->getMessage());
}

// Afficher le template Twig avec les détails de l'intervention
echo $page->render('standardiste/users/read_intervention.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => 'standardiste',
    'intervention' => $intervention
]);
?>

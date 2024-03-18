<?php
require_once '../vendor/autoload.php'; 
use App\Page;

$page = new Page();

$user_id = $page->session->get('user_id'); 



// Vérifier si le formulaire de commentaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $intervention_id = $_POST['id'];
    $comment = $_POST['comment'];

    try {
        // Mettre à jour le commentaire dans la base de données
        $stmt = $page->pdo->prepare("UPDATE intervention SET description = :comment WHERE intervention_id = :id");
        $stmt->bindParam(':id', $intervention_id, PDO::PARAM_INT);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->execute();
        
        // Rediriger vers la page précédente après la mise à jour
        header("Location: intervenant.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du commentaire : " . $e->getMessage());
    }
}

// Vérifier si le formulaire de mise à jour du statut est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
    $intervention_id = $_POST['id'];
    $status_id = $_POST['status'];

    try {
        // Mettre à jour le statut dans la base de données
        $stmt = $page->pdo->prepare("UPDATE intervention SET status_id = :status_id WHERE intervention_id = :id");
        $stmt->bindParam(':id', $intervention_id, PDO::PARAM_INT);
        $stmt->bindParam(':status_id', $status_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Rediriger vers la page précédente après la mise à jour
        header("Location: intervenant.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du statut : " . $e->getMessage());
    }
}

// Vérifier si le formulaire de mise à jour du degré d'urgence est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['degree'])) {
    $intervention_id = $_POST['id'];
    $degree_id = $_POST['degree'];

    try {
        // Mettre à jour le degré d'urgence dans la base de données
        $stmt = $page->pdo->prepare("UPDATE intervention SET degre_urgence_id = :degree_id WHERE intervention_id = :id");
        $stmt->bindParam(':id', $intervention_id, PDO::PARAM_INT);
        $stmt->bindParam(':degree_id', $degree_id, PDO::PARAM_INT);
        $stmt->execute();
        
        // Rediriger vers la page précédente après la mise à jour
        header("Location: intervenant.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur lors de la mise à jour du degré d'urgence : " . $e->getMessage());
    }
}

// Mettre à jour automatiquement le statut des interventions dont la date d'intervention est passée
try {
    $stmt = $page->pdo->prepare("UPDATE intervention SET status_id = (SELECT status_id FROM statut WHERE type = 'cloturer') WHERE date_intervention < CURDATE()");
    $stmt->execute();
} catch (PDOException $e) {
    // Gérer l'exception
    die("Erreur lors de la mise à jour automatique du statut : " . $e->getMessage());
}

// Récupérer les interventions de l'intervenant depuis la base de données
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
        i.id_intervenant = :user_id");
    $stmt->execute(['user_id' => $user_id]);
    $interventions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer l'exception
    die("Erreur: " . $e->getMessage());
}

// Récupérer tous les statuts de la base de données
$statuses = [];
try {
    $stmt = $page->pdo->prepare("SELECT * FROM statut");
    $stmt->execute();
    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Vérifier si une intervention est déjà en cours
    $intervention_en_cours = false;
    foreach ($interventions as $intervention) {
        if ($intervention['status_type'] == 'en cours') {
            $intervention_en_cours = true;
            break;
        }
    }

    // Si une intervention est en cours, retirer l'option "En cours" des statuts disponibles
    if ($intervention_en_cours) {
        foreach ($statuses as $key => $status) {
            if ($status['type'] == 'en cours') {
                unset($statuses[$key]);
                break; // Arrêter la boucle une fois que l'option "En cours" est retirée
            }
        }
    }
} catch (PDOException $e) {
    // Gérer l'exception
    die("Erreur: " . $e->getMessage());
}


// Récupérer tous les degrés d'urgence de la base de données
$degrees = [];
try {
    $stmt = $page->pdo->query("SELECT * FROM degreurgence");
    $degrees = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Gérer l'exception
    die("Erreur: " . $e->getMessage());
}

// Passer les interventions, les statuts et les degrés d'urgence à la template Twig pour l'affichage
echo $page->render('intervenant.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => 'intervenant',
    'interventions' => $interventions,
    'statuses' => $statuses,
    'degrees' => $degrees
]);
?>

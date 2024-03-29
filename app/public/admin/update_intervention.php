<?php

require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();
$page->session->get('user');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intervention_id'])) {
    $intervention_id = $_POST['intervention_id'];

    // Récupérer les détails de l'intervention en fonction de son ID depuis la base de données
    $pdo = $page->getPdo();
    $sql_select = "SELECT intervention.*, statut.type AS status_type FROM intervention 
    INNER JOIN statut ON intervention.status_id = statut.status_id
    WHERE intervention.intervention_id = ?";
    

    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$intervention_id]);
    $intervention = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$intervention) {
        // Gérer le cas où aucune intervention avec cet ID n'est trouvée
        echo "Intervention non trouvée";
        exit;
    }

    // Récupérer tous les standardistes depuis la table user
    $sql_standardistes = "SELECT * FROM user WHERE user_type = 'standardiste'";
    $stmt_standardistes = $pdo->prepare($sql_standardistes);
    $stmt_standardistes->execute();
    $standardistes = $stmt_standardistes->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer tous les intervenants depuis la table user
    $sql_intervenants = "SELECT * FROM user WHERE user_type = 'intervenant'";
    $stmt_intervenants = $pdo->prepare($sql_intervenants);
    $stmt_intervenants->execute();
    $intervenants = $stmt_intervenants->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer tous les degrés d'urgence depuis la table degreurgence
    $sql_degrees = "SELECT * FROM degreurgence";
    $stmt_degrees = $pdo->prepare($sql_degrees);
    $stmt_degrees->execute();
    $degrees = $stmt_degrees->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['date_intervention'], $_POST['nature_intervention'], $_POST['street_and_number'], $_POST['adress_complement'], $_POST['code_postal'], $_POST['ville'], $_POST['societe'], $_POST['degre_urgence_id'], $_POST['status_id'], $_POST['user_id'], $_POST['id_standardiste'], $_POST['id_intervenant'])) {
        // Mettre à jour les données de l'intervention si toutes les données POST requises sont présentes
        $data = [
            'date_intervention' => $_POST['date_intervention'],
            'nature_intervention' => $_POST['nature_intervention'],
            'street_and_number' => $_POST['street_and_number'],
            'adress_complement' => $_POST['adress_complement'],
            'code_postal' => $_POST['code_postal'],
            'ville' => $_POST['ville'],
            'societe' => $_POST['societe'],
            'degre_urgence_id' => $_POST['degre_urgence_id'],
            'status_id' => $_POST['status_id'],
            'user_id' => $_POST['user_id'],
            'id_standardiste' => $_POST['id_standardiste'],
            'id_intervenant' => $_POST['id_intervenant'],
            'intervention_id' => $intervention_id
        ];

        $sql_update = "UPDATE intervention SET date_intervention = :date_intervention, nature_intervention = :nature_intervention, street_and_number = :street_and_number, adress_complement = :adress_complement, code_postal = :code_postal, ville = :ville, societe = :societe, degre_urgence_id = :degre_urgence_id, status_id = :status_id, user_id = :user_id, id_standardiste = :id_standardiste, id_intervenant = :id_intervenant WHERE intervention_id = :intervention_id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute($data);

        // Rediriger vers la page des interventions après la mise à jour
        header("Location: interventions.php");
        exit;
    } 
} else {
    // Gérer le cas où les données POST ne sont pas envoyées correctement
    echo "Données POST non fournies";
}

$statusTypes = $page->getAllStatusTypes();

echo $page->render('admin/users/intervention_update.html.twig', [
    'intervention' => $intervention,
    'standardistes' => $standardistes, 
    'intervenants' => $intervenants,
    'degrees' => $degrees,
    'statusTypes' => $statusTypes, // Passer les types de statut au modèle Twig
    'connected' => $page->session->isConnected(),
    'user_type' => 'admin'
]);
?>

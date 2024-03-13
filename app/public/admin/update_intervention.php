<?php

require_once '../../vendor/autoload.php';

use App\Page;

$page = new Page();
$page->session->get('user');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['intervention_id'])) {
    $intervention_id = $_POST['intervention_id'];

    // Récupérer les détails de l'intervention en fonction de son ID depuis la base de données
    $pdo = $page->getPdo();
    $sql_select = "SELECT * FROM intervention WHERE intervention_id = ?";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$intervention_id]);
    $intervention = $stmt_select->fetch(PDO::FETCH_ASSOC);

    if (!$intervention) {
        // Gérer le cas où aucune intervention avec cet ID n'est trouvée
        echo "Intervention non trouvée";
        exit;
    }

    if (isset($_POST['date_intervention'], $_POST['nature_intervention'], $_POST['description'], $_POST['street_and_number'], $_POST['adress_complement'], $_POST['code_postal'], $_POST['ville'], $_POST['societe'], $_POST['degre_urgence_id'], $_POST['status_id'], $_POST['user_id'], $_POST['id_standardiste'], $_POST['id_intervenant'])) {
        // Mettre à jour les données de l'intervention si toutes les données POST requises sont présentes
        $data = [
            'date_intervention' => $_POST['date_intervention'],
            'nature_intervention' => $_POST['nature_intervention'],
            'description' => $_POST['description'],
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

        $sql_update = "UPDATE intervention SET date_intervention = :date_intervention, nature_intervention = :nature_intervention, description = :description, street_and_number = :street_and_number, adress_complement = :adress_complement, code_postal = :code_postal, ville = :ville, societe = :societe, degre_urgence_id = :degre_urgence_id, status_id = :status_id, user_id = :user_id, id_standardiste = :id_standardiste, id_intervenant = :id_intervenant WHERE intervention_id = :intervention_id";
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

echo $page->render('admin/users/intervention_update.html.twig', [
    'intervention' => $intervention,
    'connected' => $page->session->isConnected(),
    'user_type' => 'admin'
]);
?>

<?php

require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();

$page->session->get('user');

$user_id = $_SESSION['user_id']; // Assuming you've stored user_id in session after login
$conn = $page->getPdo();
// SQL pour obtenir les interventions liées à l'utilisateur connecté
$sql = "SELECT * FROM intervention WHERE user_id = ? ORDER BY date_intervention DESC";
$stmt = $conn->prepare($sql);
$stmt->bindValue(1, $user_id, PDO::PARAM_INT); // Utiliser bindValue pour lier le paramètre
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
if (count($result) > 0) {
    echo "<table><tr><th>Date</th><th>Nature</th><th>Description</th><th>Address</th><th>City</th><th>Company</th></tr>";
    // Afficher les données de chaque ligne
    foreach ($result as $row) {
        echo "<tr><td>" . $row["date_intervention"]. "</td><td>" . $row["nature_intervention"]. "</td><td>" . $row["description"]. "</td><td>" . $row["street_and_number"]. " " . $row["adress_complement"]. " " . $row["code_postal"]. "</td><td>" . $row["ville"]. "</td><td>" . $row["societe"]. "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

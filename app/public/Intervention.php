<?php

require_once '../vendor/autoload.php'; //Il nous evite de faire un require once

use App\Page;

$page = new Page();

$page->session->get('user');

$user_id = $_SESSION['user_id']; // Assuming you've stored user_id in session after login

// SQL to get interventions related to the logged-in user
$sql = "SELECT * FROM intervention WHERE user_id = ? ORDER BY date_intervention DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  echo "<table><tr><th>Date</th><th>Nature</th><th>Description</th><th>Address</th><th>City</th><th>Company</th></tr>";
  // Output data of each row
  while($row = $result->fetch_assoc()) {
    echo "<tr><td>" . $row["date_intervention"]. "</td><td>" . $row["nature_intervention"]. "</td><td>" . $row["description"]. "</td><td>" . $row["street_and_number"]. " " . $row["adress_complement"]. " " . $row["code_postal"]. "</td><td>" . $row["ville"]. "</td><td>" . $row["societe"]. "</td></tr>";
  }
  echo "</table>";
} else {
  echo "0 results";
}
$stmt->close();
$conn->close();
?>

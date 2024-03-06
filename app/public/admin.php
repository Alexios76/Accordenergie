<?php

require_once '../vendor/autoload.php'; 

use App\Page;

$page = new Page();

$user = $page->session->get('user');


if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 'admin') {
   
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id']) && isset($_POST['user_type'])) {
     
        $pdo = $page->getPdo();

     
        $user_id = $_POST['user_id'];
        $user_type = $_POST['user_type'];

        $sql_update = "UPDATE user SET user_type = :user_type WHERE user_id = :user_id";

        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute(['user_type' => $user_type, 'user_id' => $user_id]);
    }


    $pdo = $page->getPdo();

   
    $sql = "SELECT * FROM user";

    $stmt = $pdo->query($sql);


    if ($stmt->rowCount() > 0) {
      
        echo "<form method='post' action=''>";
        echo "<table border='1'>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Numéro de téléphone</th>
                    <th>Type d'utilisateur</th>
                </tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>
                    <td>".$row["user_id"]."</td>
                    <td>".$row["name"]."</td>
                    <td>".$row["surname"]."</td>
                    <td>".$row["email"]."</td>
                    <td>".$row["phone_number"]."</td>
                    <td>
                        <select name='user_type'>
                            <option value='admin' ".($row["user_type"] == 'admin' ? 'selected' : '').">Admin</option>
                            <option value='client' ".($row["user_type"] == 'client' ? 'selected' : '').">Client</option>
                            <option value='intervenant' ".($row["user_type"] == 'intervenant' ? 'selected' : '').">Intervenant</option>
                            <option value='normal' ".($row["user_type"] == 'standardiste' ? 'selected' : '').">Standardiste</option>
                        </select>
                        <input type='hidden' name='user_id' value='".$row["user_id"]."'>
                        <input type='submit' value='Modifier'>
                    </td>
                </tr>";
        }
        echo "</table>";
        echo "</form>";
    } else {
        echo "Aucun utilisateur trouvé.";
    }
} else {
    echo "Vous n'êtes pas autorisé à accéder à cette page.";
}
?>

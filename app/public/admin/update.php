    <?php

    require_once '../../vendor/autoload.php';

    use App\Page;

    $page = new Page();
    $page->session->get('user');


    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];

        // Récupérer les détails de l'utilisateur en fonction de son ID depuis la base de données
        $pdo = $page->getPdo();
        $sql_select = "SELECT * FROM user WHERE user_id = ?";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([$user_id]);
        $user = $stmt_select->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // Gérer le cas où aucun utilisateur avec cet ID n'est trouvé
            echo "Utilisateur non trouvé";
            exit;
        }

        if (isset($_POST['email'], $_POST['name'], $_POST['surname'], $_POST['phone_number'])) {
            // Mettre à jour les données de l'utilisateur si toutes les données POST requises sont présentes
            $data = [
                'email' => $_POST['email'],
                'name' => $_POST['name'],
                'surname' => $_POST['surname'],
                'phone_number' => $_POST['phone_number'],
                
                'user_id' => $user_id
            ];

            $sql_update = "UPDATE user SET email = :email,  name = :name, surname = :surname, phone_number = :phone_number WHERE user_id = :user_id";
            $stmt_update = $pdo->prepare($sql_update);
            $stmt_update->execute($data);

            // Rediriger vers la page users.php après la mise à jour
            header("Location: users.php");
            exit;
        } 
    } else {
        // Gérer le cas où les données POST ne sont pas envoyées correctement
        echo "Données POST non fournies";
    }

    echo $page->render('admin/users/list_update.html.twig', [
        
        'user' => $user,
        'connected' => $page->session->isConnected(),
        'user_type' => 'admin'


    ]);
    ?>

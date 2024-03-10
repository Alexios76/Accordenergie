<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $name = strip_tags(trim($_POST["name"]));
    $surname = strip_tags(trim($_POST["surname"]));
    $phone = strip_tags(trim($_POST["phone"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    // Vérifier que les champs requis sont remplis
    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Gérer le cas où des champs sont manquants ou invalides
        echo "Veuillez remplir tous les champs du formulaire correctement.";
        exit;
    }

    // Vous pouvez ensuite traiter ces données comme vous le souhaitez
    // Par exemple, les stocker dans une base de données ou les enregistrer dans un fichier

    // Exemple d'enregistrement dans un fichier
    $file = 'messages.txt';
    $current = file_get_contents($file);
    $current .= "Nom: $name\n";
    $current .= "Prénom: $surname\n";
    $current .= "Téléphone: $phone\n";
    $current .= "Email: $email\n";
    $current .= "Message: $message\n\n";
    file_put_contents($file, $current);

    // Message de confirmation
    echo "Merci, votre message a bien été soumis.";
} else {
    // Rediriger si le formulaire n'est pas soumis via POST
    header("Location: contact_operator.html.twig");
    exit;
}
?>

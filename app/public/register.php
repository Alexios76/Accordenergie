<?php

    require_once '../vendor/autoload.php'; //Il nous evite de faire un require once

    use App\Page;
    
    $page = new Page();

    if(isset($_POST['send'])){
        
        $page->insert('utilisateur', [
            'email'     => $_POST['email'],
            'MotDePass'  => password_hash($_POST['MotDePass'], PASSWORD_DEFAULT)]);

            header('Location: index.php');
    }

    echo $page->render('register.html', []);



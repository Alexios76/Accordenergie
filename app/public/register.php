<?php

    require_once '../vendor/autoload.php'; //Il nous evite de faire un require once

    use App\Page;
    
    $page = new Page();
    if(isset($_POST['send'])){
        // Ajoutez la valeur par défaut 'client' pour le champ 'user_type'
        $_POST['user_type'] = 'client';
        
        $page->insert('user', [
            'email'        => $_POST['email'],
            'password'     => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'name'         => $_POST['name'],
            'surname'      => $_POST['surname'],
            'phone_number' => $_POST['phone_number'],
            'user_type'    => $_POST['user_type']
        ]);
    
        header('Location: index.php');
    }
    
    echo $page->render('register.html', []);



<?php

    require_once '../vendor/autoload.php'; //Il nous evite de faire un require once

    use App\Page;
    
    $page = new Page();

    $page->session->get('user');

    $msg = false;

    if(isset($_POST['send'])){
       //var_dump($_POST); //permet d'afficher les valeurs rentré, utile pour vérifier
       
       $_SESSION = $page->getUserByEmail([
            'email' => $_POST['email']
       ]);
       //var_dump($user);

       if(!$_SESSION){
        $msg = "Email ou mot de passe incorrect";
       }else {
            if(!password_verify($_POST['password'], $_SESSION['password']))
            {
                $msg = "Email ou mot de passe incorrect !";
            }  else if ($_SESSION['user_type'] == 'admin'){
                    header("Location: admin/users.php");
            } else if ($_SESSION['user_type'] == 'client'){
                header("Location: client.php");
            } else if ($_SESSION['user_type'] == 'standardiste'){
                header("Location: standardiste.php");
            } else if ($_SESSION['user_type'] == 'intervenant'){
                header("Location: intervenant.php");
            }
            else{
                
                header("Location: accueil.php");
            }
            
       }

       
    }

    echo $page->render('index.html.twig',[
        'msg' => $msg]);


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


       

       if(!$_SESSION){
        $msg = "Email ou mot de passe incorrect";
       }else {
            if(!password_verify($_POST['password'], $_SESSION['password']))
            {
                $msg = "Email ou mot de passe incorrect !";
            }  else if ($_SESSION['user_type'] == 'admin') {
                $_SESSION['user'] = true; // Définissez la session comme connectée
                header("Location: accueil.php"); // Redirigez l'utilisateur
                exit(); // Assurez-vous de quitter le script après la redirection
            
            
            } else if ($_SESSION['user_type'] == 'client'){
                $_SESSION['user'] = true;
                header("Location: accueil.php");
            } else if ($_SESSION['user_type'] == 'standardiste'){
                $_SESSION['user'] = true;
                header("Location: accueil.php");
            } else if ($_SESSION['user_type'] == 'intervenant'){
                $_SESSION['user'] = true;
                header("Location: accueil.php");
            }
            else{
                
                header("Location: accueil.php");
            }
            
       }

       
    }

    echo $page->render('index.html.twig',[
        'msg' => $msg]);



  
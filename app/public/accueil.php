<?php

require_once '../vendor/autoload.php';
use App\Page;


$page = new Page();
$page->session->get('user');

if ($_SESSION) {
    echo $page->render('accueil.html.twig', [
        'connected' => $session->isConnected()
    ]);
    
}else{
    header("Location: index.php");
}

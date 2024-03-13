<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$page->session->get('user');


echo $page->render('accueil.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => $page->session->get('user_type')
]);
?>


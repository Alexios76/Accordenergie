<?php
require_once '../vendor/autoload.php';

use App\Page;

$page = new Page();
$page->session->get('user');

var_dump($page->session->isConnected());
echo $page->render('base_auth.html.twig', [
    'connected' => $page->session->isConnected(),
    'user_type' => $page->session->get('user_type')
]);
?>


<?php
require_once '../vendor/autoload.php';
use App\Page;

$page = new Page();


echo $page->render('contact_operator.html.twig', []);
?>

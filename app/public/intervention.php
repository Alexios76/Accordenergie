<?php

require_once '../vendor/autoload.php'; //Il nous evite de faire un require once

use App\Page;

$page = new Page();

if ($_SESSION) {
    echo $page->render('intervention.html', []);
    
}else{
    header("Location: index.php");
}

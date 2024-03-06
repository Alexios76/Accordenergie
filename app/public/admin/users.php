<?php

require_once '../../vendor/autoload.php'; //Il nous evite de faire un require once

use App\Page;

$page = new Page();

$users = $page->getAllUsers();

echo $page->render('admin/users/list.html.twig', [
    'users' => $users
]);

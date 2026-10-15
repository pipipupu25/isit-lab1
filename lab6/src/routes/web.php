<?php

use App\Controllers\HomeController;
use App\Controllers\RepairController;
use App\Controllers\ClientController;

$router->get('/', [HomeController::class, 'index']);

$router->get('/repairs', [RepairController::class, 'index']);
$router->get('/repairs/create', [RepairController::class, 'create']);
$router->get('/repairs/{id}', [RepairController::class, 'show']);
$router->post('/repairs', [RepairController::class, 'store']);

$router->get('/clients', [ClientController::class, 'index']);
$router->get('/clients/{id}', [ClientController::class, 'show']);

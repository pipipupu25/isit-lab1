<?php

use App\Controllers\Api\RepairApiController;
use App\Controllers\Api\ClientApiController;
use App\Controllers\Api\ExecutorApiController;

// Маршруты API Заявок на ремонт
$router->get('/api/repairs', [RepairApiController::class, 'index']);
$router->get('/api/repairs/{id}', [RepairApiController::class, 'show']);
$router->post('/api/repairs', [RepairApiController::class, 'store']);
$router->put('/api/repairs/{id}', [RepairApiController::class, 'update']);
$router->patch('/api/repairs/{id}', [RepairApiController::class, 'update']);
$router->delete('/api/repairs/{id}', [RepairApiController::class, 'destroy']);

// Маршруты API Клиентов
$router->get('/api/clients', [ClientApiController::class, 'index']);
$router->get('/api/clients/{id}', [ClientApiController::class, 'show']);
$router->get('/api/clients/{id}/repairs', [ClientApiController::class, 'repairs']);
$router->post('/api/clients', [ClientApiController::class, 'store']);
$router->put('/api/clients/{id}', [ClientApiController::class, 'update']);
$router->patch('/api/clients/{id}', [ClientApiController::class, 'update']);
$router->delete('/api/clients/{id}', [ClientApiController::class, 'destroy']);

// Маршруты API Исполнителей (Мастеров)
$router->get('/api/executors', [ExecutorApiController::class, 'index']);
$router->get('/api/executors/{id}', [ExecutorApiController::class, 'show']);
$router->post('/api/executors', [ExecutorApiController::class, 'store']);
$router->put('/api/executors/{id}', [ExecutorApiController::class, 'update']);
$router->patch('/api/executors/{id}', [ExecutorApiController::class, 'update']);
$router->delete('/api/executors/{id}', [ExecutorApiController::class, 'destroy']);

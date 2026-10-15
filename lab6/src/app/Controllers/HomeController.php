<?php

namespace App\Controllers;

use App\Models\RepairRepository;
use App\Models\ClientRepository;

class HomeController
{
    public function index(): void
    {
        $repairRepo = new RepairRepository();
        $clientRepo = new ClientRepository();

        $repairs = $repairRepo->all();
        $clients = $clientRepo->all();

        $inProgressCount = count(array_filter($repairs, fn($r) => $r['status'] === 'in_progress'));
        $doneCount = count(array_filter($repairs, fn($r) => $r['status'] === 'done'));

        view('home', [
            'totalRepairs' => count($repairs),
            'inProgressCount' => $inProgressCount,
            'doneCount' => $doneCount,
            'totalClients' => count($clients)
        ]);
    }
}

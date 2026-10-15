<?php

namespace App\Controllers;

use App\Models\ClientRepository;
use App\Models\RepairRepository;

class ClientController
{
    private ClientRepository $clientRepo;
    private RepairRepository $repairRepo;

    public function __construct()
    {
        $this->clientRepo = new ClientRepository();
        $this->repairRepo = new RepairRepository();
    }

    public function index(): void
    {
        $clients = $this->clientRepo->all();
        view('clients.index', [
            'clients' => $clients
        ]);
    }

    public function show(string $id): void
    {
        $client = $this->clientRepo->find((int)$id);
        if (!$client) {
            notFound();
        }

        $repairs = $this->repairRepo->byClient((int)$id);

        view('clients.show', [
            'client' => $client,
            'repairs' => $repairs
        ]);
    }
}

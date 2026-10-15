<?php

namespace App\Controllers;

use App\Models\RepairRepository;
use App\Models\ClientRepository;

class RepairController
{
    private RepairRepository $repairRepo;
    private ClientRepository $clientRepo;

    public function __construct()
    {
        $this->repairRepo = new RepairRepository();
        $this->clientRepo = new ClientRepository();
    }

    public function index(): void
    {
        $status = $_GET['status'] ?? '';
        $repairs = $this->repairRepo->filterByStatus($status);

        view('repairs.index', [
            'repairs' => $repairs,
            'currentStatus' => $status
        ]);
    }

    public function show(string $id): void
    {
        $repair = $this->repairRepo->find((int)$id);
        if (!$repair) {
            notFound();
        }

        $client = $this->clientRepo->find($repair['client_id']);

        view('repairs.show', [
            'repair' => $repair,
            'client' => $client
        ]);
    }

    public function create(): void
    {
        $clients = $this->clientRepo->all();
        view('repairs.create', [
            'clients' => $clients,
            'errors' => []
        ]);
    }

    public function store(): void
    {
        $title = trim($_POST['title'] ?? '');
        $clientId = (int)($_POST['client_id'] ?? 0);
        $priority = $_POST['priority'] ?? 'medium';

        $errors = [];
        if (mb_strlen($title) < 3) {
            $errors['title'] = 'Тема заявки должна быть не менее 3 символов';
        }
        if ($clientId <= 0) {
            $errors['client_id'] = 'Выберите клиента';
        }

        if (!empty($errors)) {
            http_response_code(422);
            $clients = $this->clientRepo->all();
            view('repairs.create', [
                'clients' => $clients,
                'errors' => $errors,
                'old' => $_POST
            ]);
            return;
        }

        $this->repairRepo->add([
            'title' => $title,
            'client_id' => $clientId,
            'priority' => $priority
        ]);

        redirect('/repairs');
    }
}

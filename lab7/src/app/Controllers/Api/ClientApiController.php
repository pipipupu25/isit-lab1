<?php

namespace App\Controllers\Api;

use App\Models\ClientRepository;
use App\Models\RepairRepository;

class ClientApiController
{
    private ClientRepository $repository;

    public function __construct()
    {
        $this->repository = new ClientRepository();
    }

    public function index(): void
    {
        json_response($this->repository->all());
    }

    public function show(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Клиент не найден', 404);
        }
        json_response($item);
    }

    public function repairs(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Клиент не найден', 404);
        }

        $repairRepo = new RepairRepository();
        $repairs = $repairRepo->filter(['client_id' => (int)$id]);
        json_response($repairs);
    }

    public function store(): void
    {
        $input = json_input();
        $errors = $this->validate($input);

        if (!empty($errors)) {
            json_error('Ошибка проверки данных', 422, $errors);
        }

        $newItem = $this->repository->add($input);
        header('Location: /api/clients/' . $newItem['id']);
        json_response($newItem, 201);
    }

    public function update(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Клиент не найден', 404);
        }

        $input = json_input();
        $errors = $this->validate($input, true);

        if (!empty($errors)) {
            json_error('Ошибка проверки данных', 422, $errors);
        }

        $updated = $this->repository->update((int)$id, $input);
        json_response($updated);
    }

    public function destroy(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Клиент не найден', 404);
        }

        $repairRepo = new RepairRepository();
        $repairs = $repairRepo->filter(['client_id' => (int)$id]);

        if (!empty($repairs)) {
            json_error('Невозможно удалить клиента, у которого есть активные заявки', 409);
        }

        $this->repository->delete((int)$id);
        no_content();
    }

    private function validate(array $data, bool $isUpdate = false): array
    {
        $errors = [];

        if (!$isUpdate || isset($data['name'])) {
            if (empty($data['name']) || mb_strlen($data['name']) < 2) {
                $errors['name'] = 'Имя клиента должно содержать минимум 2 символа';
            }
        }

        return $errors;
    }
}

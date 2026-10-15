<?php

namespace App\Controllers\Api;

use App\Models\RepairRepository;

class RepairApiController
{
    private RepairRepository $repository;

    public function __construct()
    {
        $this->repository = new RepairRepository();
    }

    public function index(): void
    {
        $filters = [];
        if (isset($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (isset($_GET['client_id'])) {
            $filters['client_id'] = $_GET['client_id'];
        }

        $data = !empty($filters) ? $this->repository->filter($filters) : $this->repository->all();
        json_response($data);
    }

    public function show(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Заявка не найдена', 404);
        }
        json_response($item);
    }

    public function store(): void
    {
        $input = json_input();
        $errors = $this->validate($input);

        if (!empty($errors)) {
            json_error('Ошибка проверки данных', 422, $errors);
        }

        $newItem = $this->repository->add($input);
        header('Location: /api/repairs/' . $newItem['id']);
        json_response($newItem, 201);
    }

    public function update(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Заявка не найдена', 404);
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
            json_error('Заявка не найдена', 404);
        }

        $this->repository->delete((int)$id);
        no_content();
    }

    private function validate(array $data, bool $isUpdate = false): array
    {
        $errors = [];

        if (!$isUpdate || isset($data['title'])) {
            if (empty($data['title']) || mb_strlen($data['title']) < 3) {
                $errors['title'] = 'Название должно быть не короче 3 символов';
            }
        }

        if (!$isUpdate || isset($data['status'])) {
            $allowedStatuses = ['in_progress', 'done'];
            if (empty($data['status']) || !in_array($data['status'], $allowedStatuses)) {
                $errors['status'] = 'Статус должен быть: in_progress или done';
            }
        }

        return $errors;
    }
}

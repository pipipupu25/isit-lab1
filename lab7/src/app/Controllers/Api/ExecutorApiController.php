<?php

namespace App\Controllers\Api;

use App\Models\ExecutorRepository;

class ExecutorApiController
{
    private ExecutorRepository $repository;

    public function __construct()
    {
        $this->repository = new ExecutorRepository();
    }

    public function index(): void
    {
        json_response($this->repository->all());
    }

    public function show(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Исполнитель не найден', 404);
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
        header('Location: /api/executors/' . $newItem['id']);
        json_response($newItem, 201);
    }

    public function update(string $id): void
    {
        $item = $this->repository->find((int)$id);
        if (!$item) {
            json_error('Исполнитель не найден', 404);
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
            json_error('Исполнитель не найден', 404);
        }

        $this->repository->delete((int)$id);
        no_content();
    }

    private function validate(array $data, bool $isUpdate = false): array
    {
        $errors = [];

        if (!$isUpdate || isset($data['name'])) {
            if (empty($data['name']) || mb_strlen($data['name']) < 2) {
                $errors['name'] = 'Имя исполнителя должно содержать минимум 2 символа';
            }
        }

        return $errors;
    }
}

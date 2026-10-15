<?php

namespace App\Models;

class RepairRepository
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = BASE_PATH . '/storage/repairs.json';
    }

    public function all(): array
    {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $data = file_get_contents($this->filePath);
        return json_decode($data, true) ?? [];
    }

    public function find(int $id): ?array
    {
        $repairs = $this->all();
        foreach ($repairs as $repair) {
            if ($repair['id'] === $id) {
                return $repair;
            }
        }
        return null;
    }

    public function filterByStatus(string $status): array
    {
        $repairs = $this->all();
        if (empty($status)) {
            return $repairs;
        }
        return array_values(array_filter($repairs, fn($r) => $r['status'] === $status));
    }

    public function byClient(int $clientId): array
    {
        $repairs = $this->all();
        return array_values(array_filter($repairs, fn($r) => $r['client_id'] === $clientId));
    }

    public function add(array $data): array
    {
        $repairs = $this->all();
        $newId = count($repairs) > 0 ? max(array_column($repairs, 'id')) + 1 : 1;

        $newRepair = [
            'id' => $newId,
            'client_id' => (int)$data['client_id'],
            'title' => $data['title'],
            'status' => 'in_progress',
            'priority' => $data['priority'],
            'created_at' => date('Y-m-d')
        ];

        $repairs[] = $newRepair;
        file_put_contents($this->filePath, json_encode($repairs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $newRepair;
    }
}

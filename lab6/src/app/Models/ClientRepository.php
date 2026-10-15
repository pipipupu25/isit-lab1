<?php

namespace App\Models;

class ClientRepository
{
    private string $filePath;

    public function __construct()
    {
        $this->filePath = BASE_PATH . '/storage/clients.json';
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
        $clients = $this->all();
        foreach ($clients as $client) {
            if ($client['id'] === $id) {
                return $client;
            }
        }
        return null;
    }
}

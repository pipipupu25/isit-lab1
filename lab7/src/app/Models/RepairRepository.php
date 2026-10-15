<?php

namespace App\Models;

class RepairRepository extends JsonRepository
{
    public function __construct()
    {
        parent::__construct('repairs.json');
    }

    public function filter(array $filters): array
    {
        $items = $this->all();

        if (!empty($filters['status'])) {
            $items = array_values(array_filter($items, fn($item) => $item['status'] === $filters['status']));
        }

        if (!empty($filters['client_id'])) {
            $items = array_values(array_filter($items, fn($item) => $item['client_id'] === (int)$filters['client_id']));
        }

        return $items;
    }
}

<?php

namespace App\Models;

abstract class JsonRepository
{
    protected string $filePath;

    public function __construct(string $filename)
    {
        $this->filePath = BASE_PATH . '/storage/' . $filename;
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
        $items = $this->all();
        foreach ($items as $item) {
            if ($item['id'] === $id) {
                return $item;
            }
        }
        return null;
    }

    public function add(array $data): array
    {
        $items = $this->all();
        $newId = count($items) > 0 ? max(array_column($items, 'id')) + 1 : 1;
        
        $newItem = array_merge(['id' => $newId], $data);
        $items[] = $newItem;
        
        $this->save($items);
        return $newItem;
    }

    public function update(int $id, array $data): ?array
    {
        $items = $this->all();
        $updatedItem = null;

        foreach ($items as &$item) {
            if ($item['id'] === $id) {
                unset($data['id']);
                $item = array_merge($item, $data);
                $updatedItem = $item;
                break;
            }
        }

        if ($updatedItem !== null) {
            $this->save($items);
        }

        return $updatedItem;
    }

    public function delete(int $id): bool
    {
        $items = $this->all();
        $initialCount = count($items);
        
        $items = array_values(array_filter($items, fn($item) => $item['id'] !== $id));

        if (count($items) < $initialCount) {
            $this->save($items);
            return true;
        }

        return false;
    }

    protected function save(array $items): void
    {
        file_put_contents(
            $this->filePath, 
            json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}

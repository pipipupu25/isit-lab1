# Документация REST API (Система заявок на ремонт)

Все адреса API начинаются с префикса `/api/`.

---

## 1. Ресурс «Заявки» (`/api/repairs`)

### `GET /api/repairs`
Возвращает список всех заявок.

**Параметры URL (опционально):**
* `status` (string) — фильтр по статусу (`in_progress`, `done`)
* `client_id` (number) — фильтр по ID клиента

**Пример ответа (200 OK):**
```json
[
  {
    "id": 1,
    "client_id": 1,
    "executor_id": 1,
    "title": "Протекает кран в каб. 104",
    "status": "in_progress",
    "priority": "high",
    "created_at": "2026-10-15"
  }
]

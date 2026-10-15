<?php

function json_response($data, int $code = 200): void
{
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function json_error(string $message, int $code = 400, array $errors = []): void
{
    $response = ['error' => $message];
    if (!empty($errors)) {
        $response['errors'] = $errors;
    }
    json_response($response, $code);
}

function no_content(): void
{
    http_response_code(204);
    exit;
}

function json_input(): array
{
    $raw = file_get_contents('php://input');
    if (empty($raw)) {
        return $_POST;
    }
    $data = json_decode($raw, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        json_error('Некорректный формат JSON', 400);
    }
    return $data ?? [];
}

function notFound(): void
{
    if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/api/')) {
        json_error('Ресурс не найден', 404);
    }
    http_response_code(404);
    echo '404 Not Found';
    exit;
}

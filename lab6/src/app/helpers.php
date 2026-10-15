<?php

function e($value)
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function view($name, $data = [])
{
    extract($data);
    $viewFile = APP_PATH . '/Views/' . str_replace('.', '/', $name) . '.php';
    $layoutFile = APP_PATH . '/Views/layout/main.php';

    if (!file_exists($viewFile)) {
        throw new Exception("View {$name} not found.");
    }

    ob_start();
    require $viewFile;
    $content = ob_get_clean();

    if (file_exists($layoutFile)) {
        require $layoutFile;
    } else {
        echo $content;
    }
}

function redirect($url)
{
    header("Location: {$url}");
    exit;
}

function notFound()
{
    http_response_code(404);
    view('errors.404');
    exit;
}

function config($key, $default = null)
{
    static $config = null;
    if ($config === null) {
        $config = require BASE_PATH . '/config/app.php';
    }
    return $config[$key] ?? $default;
}

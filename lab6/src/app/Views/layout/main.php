<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? config('name')) ?></title>
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
  <header class="header">
    <div class="container">
      <a href="/" class="logo"><?= e(config('name')) ?></a>
      <nav class="nav">
        <a href="/">Главная</a>
        <a href="/repairs">Заявки</a>
        <a href="/clients">Клиенты</a>
        <a href="/repairs/create" class="btn-create">+ Новая заявка</a>
      </nav>
    </div>
  </header>

  <main class="main container">
    <?= $content ?>
  </main>

  <footer class="footer">
    <div class="container">
      <p>&copy; <?= date('Y') ?> <?= e(config('name')) ?></p>
    </div>
  </footer>
</body>
</html>

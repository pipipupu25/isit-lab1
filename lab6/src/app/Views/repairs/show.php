<h1>Заявка #<?= $repair['id'] ?></h1>

<div class="card">
  <h2><?= e($repair['title']) ?></h2>
  <p><strong>Клиент:</strong> 
    <?php if ($client): ?>
      <a href="/clients/<?= $client['id'] ?>"><?= e($client['name']) ?></a>
    <?php else: ?>
      Не указан
    <?php endif; ?>
  </p>
  <p><strong>Приоритет:</strong> <?= e($repair['priority']) ?></p>
  <p><strong>Дата создания:</strong> <?= e($repair['created_at']) ?></p>
  <p><strong>Статус:</strong> 
    <span class="badge badge-<?= $repair['status'] ?>">
      <?= $repair['status'] === 'done' ? 'Завершено' : 'В работе' ?>
    </span>
  </p>
</div>

<a href="/repairs" class="btn" style="margin-top: 20px;">&larr; Назад к списку</a>

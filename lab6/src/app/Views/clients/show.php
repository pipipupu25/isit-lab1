<h1>Клиент: <?= e($client['name']) ?></h1>
<p><strong>Телефон:</strong> <?= e($client['phone']) ?></p>

<h2>Заявки клиента</h2>
<?php if (empty($repairs)): ?>
  <p>У данного клиента нет активных заявок.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Тема заявки</th>
        <th>Статус</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($repairs as $repair): ?>
        <tr>
          <td><?= $repair['id'] ?></td>
          <td><a href="/repairs/<?= $repair['id'] ?>"><?= e($repair['title']) ?></a></td>
          <td>
            <span class="badge badge-<?= $repair['status'] ?>">
              <?= $repair['status'] === 'done' ? 'Завершено' : 'В работе' ?>
            </span>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

<a href="/clients" class="btn" style="margin-top: 20px;">&larr; Назад к списку клиентов</a>

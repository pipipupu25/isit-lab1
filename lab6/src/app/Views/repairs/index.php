<h1>Список заявок на ремонт</h1>

<form method="GET" action="/repairs" style="margin-bottom: 20px;">
  <label for="status">Фильтр по статусу:</label>
  <select name="status" id="status" onchange="this.form.submit()">
    <option value="">Все статусы</option>
    <option value="in_progress" <?= $currentStatus === 'in_progress' ? 'selected' : '' ?>>В работе</option>
    <option value="done" <?= $currentStatus === 'done' ? 'selected' : '' ?>>Завершено</option>
  </select>
</form>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Тема заявки</th>
      <th>Приоритет</th>
      <th>Статус</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($repairs as $repair): ?>
      <tr>
        <td><?= $repair['id'] ?></td>
        <td><?= e($repair['title']) ?></td>
        <td><?= e($repair['priority']) ?></td>
        <td>
          <span class="badge badge-<?= $repair['status'] ?>">
            <?= $repair['status'] === 'done' ? 'Завершено' : 'В работе' ?>
          </span>
        </td>
        <td>
          <a href="/repairs/<?= $repair['id'] ?>" class="btn">Просмотр</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

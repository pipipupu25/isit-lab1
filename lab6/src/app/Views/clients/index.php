<h1>Список клиентов</h1>

<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Название / Имя</th>
      <th>Телефон</th>
      <th>Действия</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($clients as $client): ?>
      <tr>
        <td><?= $client['id'] ?></td>
        <td><?= e($client['name']) ?></td>
        <td><?= e($client['phone']) ?></td>
        <td>
          <a href="/clients/<?= $client['id'] ?>" class="btn">Заявки клиента</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

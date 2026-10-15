<h1>Новая заявка на ремонт</h1>

<div class="card">
  <form method="POST" action="/repairs">
    <div class="form-group">
      <label for="title">Тема / Описание поломки:</label>
      <input type="text" id="title" name="title" value="<?= e($old['title'] ?? '') ?>">
      <?php if (isset($errors['title'])): ?>
        <div class="error"><?= e($errors['title']) ?></div>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="client_id">Клиент:</label>
      <select id="client_id" name="client_id">
        <option value="">-- Выберите клиента --</option>
        <?php foreach ($clients as $client): ?>
          <option value="<?= $client['id'] ?>" <?= isset($old['client_id']) && $old['client_id'] == $client['id'] ? 'selected' : '' ?>>
            <?= e($client['name']) ?>
          </option>
        <?php endforeach; ?>
      </select>
      <?php if (isset($errors['client_id'])): ?>
        <div class="error"><?= e($errors['client_id']) ?></div>
      <?php endif; ?>
    </div>

    <div class="form-group">
      <label for="priority">Приоритет:</label>
      <select id="priority" name="priority">
        <option value="low">Низкий</option>
        <option value="medium" selected>Обычный</option>
        <option value="high">Срочный</option>
      </select>
    </div>

    <button type="submit" class="btn">Сохранить заявку</button>
  </form>
</div>

<h1>Панель управления</h1>

<div class="grid">
  <div class="card">
    <div class="card-title">Всего заявок</div>
    <div class="card-value"><?= $totalRepairs ?></div>
  </div>
  <div class="card">
    <div class="card-title">В работе</div>
    <div class="card-value" style="color: #f39c12;"><?= $inProgressCount ?></div>
  </div>
  <div class="card">
    <div class="card-title">Завершено</div>
    <div class="card-value" style="color: #27ae60;"><?= $doneCount ?></div>
  </div>
  <div class="card">
    <div class="card-title">Клиентов</div>
    <div class="card-value" style="color: #2980b9;"><?= $totalClients ?></div>
  </div>
</div>

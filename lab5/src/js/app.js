// Названия статусов и приоритетов
const STATUS_NAMES = {
  in_progress: 'В работе',
  done: 'Завершено'
};

const PRIORITY_NAMES = {
  low: 'Низкий',
  medium: 'Обычный',
  high: 'Срочный'
};

// Функция создания строки таблицы (TODO 3.1-3.4)
function createTaskRow(task) {
  const tr = document.createElement('tr');
  tr.setAttribute('data-id', task.id);
  if (task.status === 'done') {
    tr.classList.add('done');
  }

  tr.innerHTML = `
    <td>${task.id}</td>
    <td class="task-title">${task.title}</td>
    <td>${PRIORITY_NAMES[task.priority] || task.priority}</td>
    <td class="task-status">${STATUS_NAMES[task.status] || task.status}</td>
    <td>
      <button class="btn-toggle">${task.status === 'done' ? 'В работу' : 'Выполнено'}</button>
      <button class="btn-delete" style="background-color: #e74c3c;">Удалить</button>
    </td>
  `;

  // Навешиваем обработчики событий на кнопки строки
  const btnToggle = tr.querySelector('.btn-toggle');
  const btnDelete = tr.querySelector('.btn-delete');

  btnToggle.addEventListener('click', () => onDoneClick(tr, task));
  btnDelete.addEventListener('click', () => onDeleteClick(tr));

  return tr;
}

// Изменение статуса заявки (TODO 3.5)
function onDoneClick(tr, task) {
  const isDone = tr.classList.toggle('done');
  task.status = isDone ? 'done' : 'in_progress';
  
  const statusTd = tr.querySelector('.task-status');
  const btnToggle = tr.querySelector('.btn-toggle');
  
  statusTd.textContent = STATUS_NAMES[task.status];
  btnToggle.textContent = isDone ? 'В работу' : 'Выполнено';
  btnToggle.setAttribute('title', isDone ? 'Вернуть в работу' : 'Отметить как выполненное');
}

// Удаление заявки (TODO 3.6)
function onDeleteClick(tr) {
  if (confirm('Вы уверены, что хотите удалить заявку?')) {
    tr.remove();
    updateCounter();
  }
}

// Обновление счетчика элементов
function updateCounter() {
  const count = document.querySelectorAll('#task-body tr').length;
  document.getElementById('task-count').textContent = count;
}

// Валидация и добавление заявки через форму (TODO 2.1, 2.2, 3.7)
const form = document.getElementById('task-form');
form.addEventListener('submit', function onFormSubmit(event) {
  event.preventDefault(); // Отмена перезагрузки страницы

  const titleInput = document.getElementById('task-title');
  const prioritySelect = document.getElementById('task-priority');
  const errorDiv = document.getElementById('title-error');
  const titleText = titleInput.value.trim();

  if (titleText.length < 3) {
    errorDiv.classList.remove('hidden');
    return;
  }
  errorDiv.classList.add('hidden');

  const newTask = {
    id: Date.now(),
    title: titleText,
    priority: prioritySelect.value,
    status: 'in_progress'
  };

  const tbody = document.getElementById('task-body');
  const newRow = createTaskRow(newTask);
  tbody.insertBefore(newRow, tbody.firstChild);

  titleInput.value = '';
  updateCounter();
});

// Асинхронная загрузка с сервера (TODO 4.1)
async function loadTasks() {
  const status = document.getElementById('filter-status').value;
  const search = document.getElementById('search-input').value.trim();

  const url = new URL('/api/tasks', window.location.origin);
  if (status) url.searchParams.append('status', status);
  if (search) url.searchParams.append('q', search);

  const response = await fetch(url.toString());
  if (!response.ok) {
    throw new Error(`Ошибка сервера: ${response.status}`);
  }
  return await response.json();
}

// Обновление списка и обработка состояний (TODO 4.2)
async function refreshList() {
  const statusMsg = document.getElementById('status-message');
  const tbody = document.getElementById('task-body');
  const btnLoad = document.getElementById('btn-load');

  statusMsg.textContent = 'Загрузка данных...';
  statusMsg.classList.remove('hidden');
  btnLoad.disabled = true;

  try {
    const data = await loadTasks();
    tbody.innerHTML = '';

    if (data.length === 0) {
      statusMsg.textContent = 'Заявки не найдены. Измените параметры поиска.';
    } else {
      statusMsg.classList.add('hidden');
      data.forEach(task => {
        tbody.appendChild(createTaskRow(task));
      });
    }
  } catch (error) {
    statusMsg.textContent = `Не удалось загрузить данные: ${error.message}`;
    statusMsg.style.color = '#e74c3c';
  } finally {
    btnLoad.disabled = false;
    updateCounter();
  }
}

// Подключение событий для фильтров и поиска (TODO 2.3)
document.getElementById('btn-load').addEventListener('click', refreshList);
document.getElementById('filter-status').addEventListener('change', refreshList);
document.getElementById('search-input').addEventListener('input', refreshList);

// Автоматическая загрузка при старте (TODO 4.3)
refreshList();

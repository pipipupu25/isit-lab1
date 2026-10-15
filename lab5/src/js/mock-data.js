// Базовые данные заявок на ремонт
const tasks = [
  { id: 1, title: 'Протекает кран в каб. 104', status: 'in_progress', priority: 'high' },
  { id: 2, title: 'Замена лампы в аудитории 205', status: 'done', priority: 'medium' },
  { id: 3, title: 'Поломка принтера в бухгалтерии', status: 'in_progress', priority: 'high' },
  { id: 4, title: 'Нет интернета в каб. 302', status: 'done', priority: 'low' }
];

const users = [
  { id: 1, name: 'Иванов И.И.', role: 'Мастер' }
];

// Вспомогательная функция фильтрации
function filterList(list, query) {
  let result = list;
  if (query.status) {
    result = result.filter(item => item.status === query.status);
  }
  if (query.q) {
    const q = query.q.toLowerCase();
    result = result.filter(item => item.title.toLowerCase().includes(q));
  }
  return result;
}

// Эмуляция таблиц маршрутов сервера
const ROUTES = {
  'GET /api/tasks': function(query) {
    return filterList(tasks, query);
  },
  'GET /api/users': function() {
    return users;
  }
};

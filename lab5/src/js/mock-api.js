// Движок эмуляции сервера
(function() {
  let delayMin = 300;
  let delayMax = 800;
  let errorRate = 0;
  let networkDown = false;

  window.MockApi = {
    setDelay(min, max) { delayMin = min; delayMax = max || min; },
    setErrorRate(rate) { errorRate = rate; },
    setNetworkDown(flag) { networkDown = flag; }
  };

  const originalFetch = window.fetch;
  window.fetch = function(url, options) {
    return new Promise((resolve, reject) => {
      const delay = Math.random() * (delayMax - delayMin) + delayMin;
      
      setTimeout(() => {
        if (networkDown) {
          return reject(new TypeError('Failed to fetch (NetworkError)'));
        }
        if (Math.random() < errorRate) {
          return resolve({
            ok: false,
            status: 500,
            json: async () => ({ error: 'Внутренняя ошибка сервера (500)' })
          });
        }

        const urlObj = new URL(url, window.location.origin);
        const path = urlObj.pathname;
        const query = {};
        urlObj.searchParams.forEach((val, key) => query[key] = val);

        const routeKey = `GET ${path}`;
        if (ROUTES[routeKey]) {
          const data = ROUTES[routeKey](query);
          resolve({
            ok: true,
            status: 200,
            json: async () => data
          });
        } else {
          resolve({
            ok: false,
            status: 404,
            json: async () => ({ error: `Маршрут ${path} не найден (404)` })
          });
        }
      }, delay);
    });
  };
})();


document.addEventListener('DOMContentLoaded', () => {
  const getCellValue = (tr, idx) => tr.children[idx].innerText.trim();

  const comparer = (idx, asc) => (a, b) => {
    return getCellValue(asc ? a : b, idx).localeCompare(getCellValue(asc ? b : a, idx));
  };

  document.querySelectorAll('th.sortable').forEach(th => {
    let asc = true;
    th.addEventListener('click', () => {
      const table = th.closest('table');
      const tbody = table.querySelector('tbody');
      Array.from(tbody.querySelectorAll('tr'))
        .sort(comparer(th.dataset.column, asc = !asc))
        .forEach(tr => tbody.appendChild(tr));

      // Atualiza ícones
      document.querySelectorAll('th.sortable i').forEach(icon => {
        icon.className = 'fa-solid fa-sort';
      });
      th.querySelector('i').className = asc ? 'fa-solid fa-sort-up' : 'fa-solid fa-sort-down';
    });
  });
});
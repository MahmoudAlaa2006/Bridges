document.addEventListener('DOMContentLoaded', () => {
  const qInputs = document.querySelectorAll('.q-input');
  const totalDisplay = document.getElementById('totalQuestions');

  function updateTotal() {
    let total = 0;
    qInputs.forEach(input => {
      const val = parseInt(input.value) || 0;
      total += val;
    });
    totalDisplay.innerText = total;
  }

  qInputs.forEach(input => {
    input.addEventListener('input', updateTotal);
    input.addEventListener('change', updateTotal);
  });
  
  updateTotal();
});
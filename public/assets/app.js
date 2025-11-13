document.addEventListener('DOMContentLoaded', () => {
  const alerts = document.querySelectorAll('.auto-dismiss');
  alerts.forEach(a => setTimeout(() => a.remove(), 4000));

  const qrField = document.getElementById('qrField');
  const inBtn = document.querySelector('[name="action"][value="in"]');
  const outBtn = document.querySelector('[name="action"][value="out"]');
  if (qrField && inBtn && outBtn) {
    const setEnabled = (ok) => { inBtn.disabled = outBtn.disabled = !ok; };
    setEnabled(!!qrField.value);
    qrField.addEventListener('input', () => setEnabled(!!qrField.value.trim()));
  }
});

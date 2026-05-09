document.addEventListener('DOMContentLoaded', function () {

  function getCsrf() {
    return document.querySelector('meta[name="csrf-token"]')?.content || '';
  }

  function url(path) {
    const base = document.querySelector('meta[name="base-url"]');
    const baseUrl = base ? base.content.replace(/\/$/, '') : '';
    return baseUrl + path;
  }

  document.querySelectorAll('.btn-add-cart').forEach(btn => {
    btn.addEventListener('click', function () {
      const id = this.dataset.id;
      const orig = this.innerHTML;
      this.innerHTML = 'Adding...';
      this.disabled = true;

      fetch(url('/cart/add'), {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': getCsrf()
        },
        body: JSON.stringify({ product_id: id, qty: 1 })
      })
      .then(r => r.json())
      .then(data => {
        if (data.success) {
          const countEl = document.getElementById('cartCount');
          if (countEl) countEl.textContent = data.count;
          this.innerHTML = '✓ Added!';
          this.style.background = '#10b981';
          setTimeout(() => {
            this.innerHTML = orig;
            this.style.background = '';
            this.disabled = false;
          }, 1500);
        }
      })
      .catch(() => {
        this.innerHTML = orig;
        this.disabled = false;
      });
    });
  });

});
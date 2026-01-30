const aDestroys = document.querySelectorAll('.link-destroy');
const form = document.getElementById('form-delete');
const logoutLink = document.getElementById('logout-link');

logoutLink.addEventListener('click', () => {
  document.getElementById('logout-form').submit();
});

const destroyModal = document.getElementById('destroyModal');
if(destroyModal) {
  destroyModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const nombre = button.dataset.nombre || 'elemento'; // Generic or from data-nombre
      const href = button.dataset.href;
      form.action = href;
      const destroyModalContent = document.getElementById('destroyModalContent'); // Ensure this ID exists in your modal HTML
      if(destroyModalContent) {
           destroyModalContent.textContent = `¿Seguro que quieres eliminar: ${nombre}?`;
      }
  });

  aDestroys.forEach(item => {
      item.addEventListener('click', () => {
          if(confirm('¿Seguro que quieres borrar este elemento?')) {
              form.action = item.dataset.href;
              form.submit();
          }
      });
  });
}

/*document.addEventListener('click', event => {
  if (event.target.classList.contains('link-destroy')) {
    console.log('a href clicked:', event.target.dataset.href);
  } else {
    console.log('click');
  }
});*/
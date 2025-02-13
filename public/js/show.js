document.addEventListener('DOMContentLoaded', () => {
    const card = document.querySelector('.card');
    if (card) {
      // Petit délai pour s'assurer que le rendu est prêt
      setTimeout(() => {
        card.classList.add('visible');
      }, 100);
    }
  });

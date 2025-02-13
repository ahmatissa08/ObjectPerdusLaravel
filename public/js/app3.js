document.addEventListener('DOMContentLoaded', () => {
    // Sélectionner toutes les cartes d'objets
    const items = document.querySelectorAll('.item');

    // Options de l'observer (dès qu'un élément apparaît à 10 % dans la zone de vue)
    const observerOptions = {
      root: null,
      threshold: 0.1,
    };

    // Création de l'observer pour déclencher l'animation de fade-in
    const observer = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          // Arrêter l'observation de cet élément une fois visible
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    // Observer chaque carte d'objet
    items.forEach(item => {
      observer.observe(item);
    });
  });

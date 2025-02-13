// Attendre que le DOM soit chargé
document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('header');
    const mobileMenu = document.getElementById('mobile-menu');
    const navList = document.getElementById('nav-list');

    // Effet de scroll sur le header
    window.addEventListener('scroll', () => {
      header.classList.toggle('scrolled', window.scrollY > 50);
    });

    // Toggle du menu mobile
    mobileMenu.addEventListener('click', () => {
      navList.classList.toggle('active');
      mobileMenu.classList.toggle('active');
    });

    // Fermer le menu si clic en dehors
    document.addEventListener('click', (event) => {
      if (!event.target.closest('.nav')) {
        navList.classList.remove('active');
        mobileMenu.classList.remove('active');
      }
    });

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({ behavior: 'smooth' });
        }
      });
    });
  });

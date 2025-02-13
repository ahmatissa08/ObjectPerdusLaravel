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

    // Fermer le menu mobile si clic en dehors
    document.addEventListener('click', (event) => {
      if (!event.target.closest('.nav') && navList.classList.contains('active')) {
        navList.classList.remove('active');
        mobileMenu.classList.remove('active');
      }
    });

    // Smooth scroll pour les liens d’ancrage
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        const targetElement = document.querySelector(this.getAttribute('href'));
        if (targetElement) {
          targetElement.scrollIntoView({
            behavior: 'smooth'
          });
        }
      });
    });
  });

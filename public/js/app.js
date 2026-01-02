// public/js/app.js
document.addEventListener('DOMContentLoaded', function() {
    // Alert auto-hide
    const alert = document.getElementById('alert');
    if (alert) {
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    }

    // Mobile menu toggle
    const navToggle = document.getElementById('navToggle');
    const navMenu = document.getElementById('navMenu');
    
    if (navToggle && navMenu) {
        navToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
        });
    }
});
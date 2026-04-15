window.toggleMobileMenu = function() {
    const menu = document.getElementById('mobile-menu');
    menu.classList.toggle('hidden');
}

window.addEventListener('resize', () => {
    if (window.innerWidth >= 768) {
        document.getElementById('mobile-menu').classList.add('hidden');
    }
});
tailwind.config = {
    darkMode: 'class'
  }

document.addEventListener('DOMContentLoaded', () => {
    const toggleBtn = document.getElementById('themeBtn');
    const htmlElement = document.documentElement;

    const savedTheme = localStorage.getItem('color-theme');
    if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
        htmlElement.classList.add('dark');
    } else {
        htmlElement.classList.remove('dark');
    }

    toggleBtn.addEventListener('click', () => {
        if (htmlElement.classList.contains('dark')) {
            htmlElement.classList.remove('dark');
            localStorage.setItem('color-theme', 'light');
        } else {
            htmlElement.classList.add('dark');
            localStorage.setItem('color-theme', 'dark');
        }
    });
});
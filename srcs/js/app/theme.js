const body = document.querySelector('BODY');
const themeBtn = document.querySelector('#theme');
const userTheme = window.matchMedia('(prefers-color-scheme: dark)');

if (themeBtn) {
    themeBtn.addEventListener('input', cambiarTheme);
}

export function cargarTtheme() {
    const theme = localStorage.getItem('theme') ?? null;
    if (!theme) {
        if(userTheme) {
            localStorage.setItem('theme', 'dark');
            themeBtn.checked = true;
            body.classList.add('dark');
        } else {
            localStorage.setItem('theme', 'light');
            body.classList.add('light');
        }
    } else {
        if (theme === 'dark') {
            themeBtn.checked = true;
        }
        body.classList.add(theme);
    }
}

function cambiarTheme(e) {
    let theme = localStorage.getItem('theme') ?? null;
    if (body.classList.contains(theme)) {
        body.classList.remove(theme);
    }
    if (theme === 'light') {
        localStorage.setItem('theme', 'dark');
        themeBtn.checked = true;
    } else {
        localStorage.setItem('theme', 'light');
    }
    theme = localStorage.getItem('theme') ?? null;
    body.classList.add(theme);
}
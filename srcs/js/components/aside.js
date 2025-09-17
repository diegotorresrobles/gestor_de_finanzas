const aside = document.querySelector('.aside');
const asideMenuBtn = document.querySelector('.aside__menu-btn');
export const dropdownBtn = document.querySelectorAll('.aside__btn');

export function alternarDropdow(e) {
    const dropdown = e.target.parentElement;
    if(!dropdown.classList.contains('aside__dropdown--activo')) {
        dropdown.classList.add('aside__dropdown--activo');
    } else {
        dropdown.classList.remove('aside__dropdown--activo');
    }
}
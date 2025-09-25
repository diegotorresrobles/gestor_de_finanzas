export function crearModal(ref, html) {
    const modal = document.createElement('DIV');
    modal.classList.add('modal');
    modal.innerHTML = html;
    ref.appendChild(modal);
}
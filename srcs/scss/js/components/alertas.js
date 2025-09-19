export function crearAlerta(ref, estado, tipo = '', mensaje, timeout = false) {
    const alertaPrev = ref.querySelector('.alerta');
    if(alertaPrev) return;
    const alertaDiv = document.createElement('DIV');
    alertaDiv.classList.add('alerta', `alerta--${estado}`);
    if(tipo !== '') {
        alertaDiv.classList.add(`alerta--${tipo}`);
    }
    alertaDiv.textContent = mensaje;
    ref.appendChild(alertaDiv);
    if(timeout) {
        setTimeout(() => {
            alertaDiv.remove();
        }, 3000);
    }
}
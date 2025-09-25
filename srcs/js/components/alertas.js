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
export function crearAlerta1(obj) {
    const deft = {timeout: false, tipo: 'baner'};
    const conf = {...deft, ...obj};
    const alertaPrev = conf.ref.querySelector('.alerta');
    if(alertaPrev) return;
    const alertaDiv = document.createElement('DIV');
    alertaDiv.classList.add('alerta', `alerta--${conf.estado}`);
    if(conf.tipo !== '') {
        alertaDiv.classList.add(`alerta--${conf.tipo}`);
    }
    alertaDiv.textContent = conf.mensaje;
    conf.ref.appendChild(alertaDiv);
    if(conf.timeout) {
        setTimeout(() => {
            alertaDiv.remove();
        }, 3000);
    }
}
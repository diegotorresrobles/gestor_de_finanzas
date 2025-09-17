import { crearElemento } from "./elementos";

export function mostrarAlerta(ref, mensaje, tipo) {
    const alertaPrev = ref.querySelector('.alerta');
    if(alertaPrev) return;
    const alerta = crearElemento({
        tipo: 'DIV',
        class: ['alerta', `alerta--${tipo}`],
        textContent: mensaje,
        append: ref
    });
    setTimeout((() => {
        alerta.remove();
    }), 3000)
    return alerta;
}
export function mostrarAlertaChica(ref, mensaje, tipo) {
    const alertaPrev = ref.querySelector('.alerta');
    if(alertaPrev) return;
    const alerta = crearElemento({
        tipo: 'DIV',
        class: ['alerta', 'alerta--right',`alerta--${tipo}`],
        textContent: mensaje,
        append: ref
    });
    return alerta;
}

export function limpiarAlerta(ref) {
    if(ref.querySelector('.alerta')) {
        ref.querySelector('.alerta').remove();
    }
}
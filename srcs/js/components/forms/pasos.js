import { formSubmitBtn, validarInputs } from './forms.js';

let inputs = document.querySelectorAll('.form__input');

export const pasos = document.querySelectorAll('.paso');
const pasoAnteriorBtn = document.querySelector('.paso__btn--anterior');
const pasoSiguienteBtn = document.querySelector('.paso__btn--siguiente');
let pasoActual = 1;
let pasosTotal = pasos.length;

export function iniciarPasos() {
    // if(pasos.length > 0) {
    //     window.addEventListener('keydown', e => {
    //         if (e.key === 'Enter' && !pasoSiguienteBtn.classList.contains('paso__btn--ocultar')) {
    //             e.preventDefault();
    //             pasoSiguiente();
    //         }
    //     });
    //     pasoSiguienteBtn.addEventListener('click', pasoSiguiente);
    //     pasoAnteriorBtn.addEventListener('click', pasoAnterior);
    // }
}

function pasoSiguiente() {
    inputs = document.querySelectorAll('.paso--activo .form__input');
    console.log(document.querySelector('.alerta'))
    validarInputs();
    if (pasoActual < pasosTotal) {
        pasoActual++;
        pasoAnteriorBtn.classList.remove('paso__btn--ocultar');
    }
    if(pasoActual === 3) {
        pasoSiguienteBtn.classList.add('paso__btn--ocultar');
        formSubmitBtn.classList.add('form__submit--visible');
    }
    mostrarPaso(pasoActual);
}

function pasoAnterior() {
    inputs = document.querySelectorAll('.paso--activo .form__input');
    console.log(inputs)
    if (pasoActual > 1) {
        pasoActual--;
        pasoSiguienteBtn.classList.remove('paso__btn--ocultar');
    }
    if(pasoActual === 1) {
        pasoAnteriorBtn.classList.add('paso__btn--ocultar');
    }
    if(pasoActual <= pasosTotal) {
        formSubmitBtn.classList.remove('form__submit--visible');
    }
    mostrarPaso(pasoActual);
}

function mostrarPaso(paso) {
    const pasoActivo = document.querySelector('.paso--activo');
    pasoActivo.classList.remove('paso--activo');
    document.querySelector(`.paso[data-paso="${paso}"]`).classList.add('paso--activo');
}
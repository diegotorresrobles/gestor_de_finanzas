import { form, enviarForm } from './../components/forms.js';

export function iniciarLogin() {
    if(form && form.classList.contains('form--login')) {
        form.addEventListener('submit', (e) => {
            enviarForm(e, '/api/login', form);
        });
    }
}
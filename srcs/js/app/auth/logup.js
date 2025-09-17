import { enviarForm } from "../../components/forms/forms.js";

const formLogup = document.querySelector('.form--logup');
if(formLogup) {
    formLogup.addEventListener('submit', (e) => enviarForm(e , '/api/logup', formLogup));
}
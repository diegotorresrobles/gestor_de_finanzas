export function crearElemento(obj) {
    const elemento = document.createElement(obj.tipo);
    // Clases
    if(obj.class) {
        if(Array.isArray(obj.class)) {
            elemento.classList.add(...obj.class);
        } else {
            elemento.classList.add(obj.class);
        }
    }
    // Texto
    if(obj.textContent) elemento.textContent = obj.textContent;
    // InnerHTML
    if(obj.innerHTML) elemento.innerHTML = obj.innerHTML;
    
    // Atributos (src, href, alt, etc.)
    if(obj.attrs) {
        Object.entries(obj.attrs).forEach(([key, value]) => {
            elemento.setAttribute(key, value);
        });
    }
    // Dataset dinámico
    if(obj.dataset) {
        Object.entries(obj.dataset).forEach(([key, value]) => {
            elemento.dataset[key] = value;
        });
    }
    // Eventos
    if(obj.events) {
        Object.entries(obj.events).forEach(([event, handler]) => {
            elemento.addEventListener(event, handler);
        });
    }
    // Append al padre
    if(obj.append) {
        obj.append.appendChild(elemento);
    }
    return elemento;
}
export function observarVisibilidad(elemento, callback, visibilidad) {
    if (!elemento) return;
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            callback(entry.isIntersecting);
        });
    }, {
        threshold: visibilidad // Porcentaje del elemento que debe ser visible
    });
    
    observer.observe(elemento);
}
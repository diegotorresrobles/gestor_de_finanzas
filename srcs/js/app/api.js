export async function apiPost(url, data) {
    try {
        const peticion = await fetch(url, {
            method: "POST",
            credentials: "include",
            headers: { 'X-Requested-With': 'Fetch' },
            body: data
        });
        return peticion.json();
    } catch (error) {
        console.error('Error: ' + error);
    }
}
export async function apiGet(url) {
    try {
        const peticion = await fetch(url, {
            method: "GET",
            credentials: "include",
            headers: { 'X-Requested-With': 'Fetch' }
        });
        return peticion.json();
    } catch (error) {
        console.error('Error: ' + error)
    }
}
export async function apiPut(url, data) {
    try {
        const peticion = await fetch(url, {
            method: "POST",
            credentials: "include",
            headers: { 'X-Requested-With': 'Fetch' },
            body: data
        });
        return peticion.json();
    } catch (error) {
        console.error('Error: ' + error);
    }
}
export async function apiDelete(url) {
    try {
        const peticion = await fetch(url, {
            method: "DELETE",
            credentials: "include",
            headers: { 'X-Requested-With': 'Fetch' }
        });
        return peticion.json();
    } catch (error) {
        console.error('Error: ' + error);
    }
}
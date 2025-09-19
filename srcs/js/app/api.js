export async function apiGet(url) {
    try {
        const req = await fetch(url, {
            method: 'GET'
        });
        if (!req.ok) {
            throw new Error(`Response status: ${req.status}`);
        }
        return req.json();
    } catch (error) {
        console.error(error);
    }
}
export async function apiPost(url, form, method = 'POST') {
    try {
        const data = new FormData(form);
        const req = await fetch(url, {
            method: 'POST',
            body: data
        });
        if (!req.ok) {
            throw new Error(`Response status: ${req.status}`);
        }
        const res = req.json();
        return res;
    } catch (error) {
        console.error(error);
    }
}
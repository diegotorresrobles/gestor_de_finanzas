export async function obtenerHTML(vista) {
    try {
        const req = await fetch(vista);
        const res = await req.text();
        console.log(res);
    } catch (error) {
        console.error(error);
    }
}
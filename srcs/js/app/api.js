import { isValidElement } from "react";

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
export async function apiPost(url, form = false, method = 'POST', dats = {}) {
    try {
        let data;
        if(form) {
            data = new FormData(form);
        } else {
            data = dats;
        }
        if(method !== 'POST') {
            data.append('_method', method);
        }
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
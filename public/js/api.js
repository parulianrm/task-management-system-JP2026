async function apiGet(url) {
    const res = await fetch(url);
    if (!res.ok) {
        throw new Error('Gagal mengambil data dari ' + url);
    }
    return res.json();
}

async function apiPost(url, data) {
    const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    });
    return res.json();
}

<html>
<head>
    <meta charset="utf-8">
    <title>Categorías API</title>
    <style>body{font-family:Arial;margin:20px} button{margin:8px 0}</style>
</head>
<body>
    <h1>Categorías</h1>
    <p>Token actual: <code id="tokenDisplay"></code></p>
    <button id="fetchBtn">Obtener categorías</button>
    <h3>Respuesta</h3>
    <pre id="output"></pre>

    <script>
    const baseUrl = '<?php echo BASE_URL; ?>apirest/api/';
    document.getElementById('tokenDisplay').textContent = localStorage.getItem('api_token') || '(no token)';
    document.getElementById('fetchBtn').addEventListener('click', async () => {
        const token = localStorage.getItem('api_token');
        const res = await fetch(baseUrl + 'categorias', {
            headers: token ? { 'Authorization': 'Bearer ' + token } : {}
        });
        const json = await res.json();
        document.getElementById('output').textContent = JSON.stringify(json, null, 2);
    });
    </script>
</body>
</html>

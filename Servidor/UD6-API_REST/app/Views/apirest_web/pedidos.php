<html>
<head>
    <meta charset="utf-8">
    <title>Pedidos API</title>
    <style>body{font-family:Arial;margin:20px} label{display:block;margin:6px 0}</style>
</head>
<body>
    <h1>Pedidos por Restaurante</h1>
    <p>Token actual: <code id="tokenDisplay"></code></p>
    <form id="frm">
        <label>PK restaurante: <input name="pk" required></label>
        <button type="submit">Obtener pedidos</button>
    </form>
    <h3>Respuesta</h3>
    <pre id="output"></pre>

    <script>
    const baseUrl = '<?php echo BASE_URL; ?>apirest/api/';
    document.getElementById('tokenDisplay').textContent = localStorage.getItem('api_token') || '(no token)';
    document.getElementById('frm').addEventListener('submit', async e => {
        e.preventDefault();
        const pk = e.target.pk.value;
        const token = localStorage.getItem('api_token');
        const res = await fetch(baseUrl + 'pedidos/' + encodeURIComponent(pk), {
            headers: token ? { 'Authorization': 'Bearer ' + token } : {}
        });
        const json = await res.json();
        document.getElementById('output').textContent = JSON.stringify(json, null, 2);
    });
    </script>
</body>
</html>

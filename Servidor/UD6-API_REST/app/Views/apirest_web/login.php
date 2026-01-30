<html>
<head>
    <meta charset="utf-8">
    <title>Login API</title>
    <style>body{font-family:Arial;margin:20px} label{display:block;margin:6px 0}</style>
</head>
<body>
    <h1>Login (API)</h1>
    <form id="loginForm">
        <label>Email: <input type="email" name="email" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <button type="submit">Login</button>
    </form>

    <h3>Respuesta</h3>
    <pre id="output"></pre>

    <script>
    const baseUrl = '<?php echo BASE_URL; ?>apirest/api/';

    document.getElementById('loginForm').addEventListener('submit', async e => {
        e.preventDefault();
        const form = e.target;
        const data = { email: form.email.value, password: form.password.value };
        const res = await fetch(baseUrl + 'login', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const json = await res.json();
        document.getElementById('output').textContent = JSON.stringify(json, null, 2);
        if (json.token) {
            localStorage.setItem('api_token', json.token);
        }
    });
    </script>
</body>
</html>

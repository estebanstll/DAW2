document.addEventListener("DOMContentLoaded", () => {
  const loginForm = document.getElementById("loginForm");
  const usuarioInput = document.getElementById("usuario");
  const passwordInput = document.getElementById("password");
  const mensaje = document.getElementById("mensaje");

  // Datos de ejemplo (usuario y contraseña correctos)
  const usuarioCorrecto = "admin";
  const passwordCorrecto = "1234";

  loginForm.addEventListener("submit", (e) => {
    e.preventDefault();

    const usuario = usuarioInput.value.trim();
    const password = passwordInput.value.trim();

    if (usuario === usuarioCorrecto && password === passwordCorrecto) {
      // Guardar sesión
      sessionStorage.setItem("logueado", "true");
      mensaje.textContent = "Inicio de sesión correcto. Redirigiendo...";
      // Redirigir a página protegida
      setTimeout(() => {
        window.location.href = "panel.html";
      }, 1000);
    } else {
      mensaje.textContent = "Usuario o contraseña incorrectos.";
    }
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const contenido = document.getElementById("contenido");
  const btnCerrar = document.getElementById("cerrar");

  // Verificar sesión
  if (sessionStorage.getItem("logueado") !== "true") {
    contenido.textContent = "No estás logueado. Redirigiendo al login...";
    setTimeout(() => {
      window.location.href = "login.html";
    }, 1000);
  }

  // Cerrar sesión
  btnCerrar.addEventListener("click", () => {
    sessionStorage.removeItem("logueado");
    window.location.href = "index.html";
  });
});

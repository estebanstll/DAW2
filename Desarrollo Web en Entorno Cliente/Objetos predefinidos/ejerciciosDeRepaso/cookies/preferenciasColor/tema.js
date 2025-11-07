document.addEventListener("DOMContentLoaded", () => {
  const estado = document.getElementById("estado");
  const btn = document.getElementById("cambiar");

  // Función para obtener una cookie por nombre
  function getCookie(nombre) {
    const valor = `; ${document.cookie}`;
    const partes = valor.split(`; ${nombre}=`);
    if (partes.length === 2) return partes.pop().split(";").shift();
  }

  // Función para actualizar el texto visible
  function mostrarTema() {
    const tema = getCookie("tema") || "claro"; // por defecto "claro"
    estado.textContent = `Estás usando el tema ${tema}`;
  }

  // Mostrar el tema al cargar
  mostrarTema();

  // Cambiar tema al hacer clic
  btn.addEventListener("click", () => {
    const temaActual = getCookie("tema") || "claro";
    const nuevoTema = temaActual === "claro" ? "oscuro" : "claro";
    document.cookie = `tema=${nuevoTema}; path=/; max-age=31536000`; // 1 año
    mostrarTema();
  });
});

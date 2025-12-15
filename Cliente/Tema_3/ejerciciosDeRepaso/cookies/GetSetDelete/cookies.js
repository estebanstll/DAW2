document.addEventListener("DOMContentLoaded", () => {
  const nombre = document.getElementById("nombre");
  const valor = document.getElementById("valor");
  const crear = document.getElementById("crear");
  const leer = document.getElementById("leer");
  const borrar = document.getElementById("borrar");
  const listar = document.getElementById("listar");
  const resultado = document.getElementById("resultado");

  // Crear cookie con nombre y valor personalizados
  crear.addEventListener("click", () => {
    const nom = nombre.value.trim();
    const val = valor.value.trim();

    if (!nom || !val) {
      resultado.textContent = "Por favor, completa ambos campos 😅";
      return;
    }

    document.cookie = `${nom}=${val}; path=/; max-age=3600`; // 1 hora
    resultado.textContent = `Cookie '${nom}' creada con valor '${val}'.`;
  });

  // Leer una cookie específica
  leer.addEventListener("click", () => {
    const nom = nombre.value.trim();
    if (!nom) {
      resultado.textContent =
        "Escribe el nombre de la cookie que querés leer 📖";
      return;
    }

    const val = getCookie(nom);
    resultado.textContent = val
      ? `La cookie '${nom}' tiene el valor: ${val}`
      : `No existe una cookie llamada '${nom}' 😕`;
  });

  // Borrar una cookie específica
  borrar.addEventListener("click", () => {
    const nom = nombre.value.trim();
    if (!nom) {
      resultado.textContent =
        "Escribe el nombre de la cookie que querés borrar 🧹";
      return;
    }

    document.cookie = `${nom}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
    resultado.textContent = `Cookie '${nom}' eliminada 💀`;
  });

  // Listar todas las cookies actuales
  listar.addEventListener("click", () => {
    if (document.cookie === "") {
      resultado.textContent = "No hay cookies guardadas 🍪";
      return;
    }

    const cookies = document.cookie.split("; ").map((c) => c.trim());
    resultado.innerHTML =
      "<strong>Cookies actuales:</strong><br>" + cookies.join("<br>");
  });

  // Función para obtener una cookie por nombre
  function getCookie(nombre) {
    const valor = `; ${document.cookie}`;
    const partes = valor.split(`; ${nombre}=`);
    if (partes.length === 2) return partes.pop().split(";").shift();
  }
});

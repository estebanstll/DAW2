// Productos de ejemplo
const PRODUCTS = [
  {
    nombre: "iPhone 13",
    categoria: "moviles",
    precio: 750,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Samsung Galaxy S22",
    categoria: "moviles",
    precio: 680,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Camiseta Nike",
    categoria: "ropa",
    precio: 25,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Pantalón Levi’s",
    categoria: "ropa",
    precio: 45,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Portátil HP",
    categoria: "electronica",
    precio: 800,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Auriculares Sony",
    categoria: "electronica",
    precio: 120,
    imagen: "https://via.placeholder.com/220",
  },
  {
    nombre: "Silla Gamer",
    categoria: "hogar",
    precio: 130,
    imagen: "https://via.placeholder.com/220",
  },
];

/**
 * Se ejecuta al cargar el DOM.
 * Inicializa resultados, tema y botones de usuario.
 */
document.addEventListener("DOMContentLoaded", () => {
  mostrarResultados(PRODUCTS.slice(0, 4));

  // Aplicar tema guardado en localStorage
  if (localStorage.getItem("theme") === "dark")
    document.body.classList.add("dark");
  actualizarIconoTema();

  const usuario = localStorage.getItem("usuario");
  actualizarBotonesUsuario(usuario);
});

/**
 * Muestra una lista de productos en el contenedor principal.
 * @param {Array} lista - Lista de objetos de producto.
 */
function mostrarResultados(lista) {
  const contenedor = document.getElementById("results");
  contenedor.innerHTML = "";

  if (lista.length === 0)
    return (contenedor.innerHTML = "<p>No se encontraron resultados.</p>");

  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");
    card.innerHTML = `
      <img src="${p.imagen}" alt="${p.nombre}">
      <h3>${p.nombre}</h3>
      <p><strong>${p.precio} €</strong></p>
    `;
    contenedor.appendChild(card);
  });
}

// ==========================
// BÚSQUEDA
// ==========================
document.getElementById("btnBuscar").addEventListener("click", () => {
  const query = document.getElementById("search").value.trim();
  if (!query) return;

  // Redirige a buscar.html con query como parámetro
  window.location.href = `buscar.html?q=${encodeURIComponent(query)}`;
});

// ==========================
// FILTRO POR CATEGORÍAS
// ==========================
document.querySelectorAll(".category").forEach((cat) => {
  cat.addEventListener("click", () => {
    const resultados = PRODUCTS.filter((p) => p.categoria === cat.dataset.cat);
    mostrarResultados(resultados);
  });
});

// ==========================
// TEMA (CLARO / OSCURO)
// ==========================
const themeBtn = document.getElementById("themeToggle");

/**
 * Actualiza el icono del botón de tema según el estado actual.
 */
function actualizarIconoTema() {
  const icon = themeBtn?.querySelector("i");
  if (!icon) return;
  icon.classList.toggle("fa-sun", document.body.classList.contains("dark"));
  icon.classList.toggle("fa-moon", !document.body.classList.contains("dark"));
}

// Alternar tema y guardar en localStorage
themeBtn?.addEventListener("click", () => {
  document.body.classList.toggle("dark");
  localStorage.setItem(
    "theme",
    document.body.classList.contains("dark") ? "dark" : "light"
  );
  actualizarIconoTema();
});

// ==========================
// MODALES
// ==========================
/**
 * Abre un modal por su ID.
 * @param {string} id - ID del modal a abrir.
 */
function abrirModal(id) {
  document.getElementById(id).style.display = "flex";
}

/**
 * Cierra un modal por su ID.
 * @param {string} id - ID del modal a cerrar.
 */
function cerrarModal(id) {
  document.getElementById(id).style.display = "none";
}

// ==========================
// REGISTRO / LOGIN
// ==========================
/**
 * Registra un usuario enviando los datos al backend.
 * @async
 * @returns {Promise<void>}
 */
async function registrar() {
  const nombre = document.getElementById("regNombre").value.trim();
  const email = document.getElementById("regEmail").value.trim();
  const pass = document.getElementById("regPass").value.trim();

  if (!nombre || !email || !pass) return alert("Completa todos los campos");

  const res = await fetch("backend/register.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ nombre, email, contrasena: pass }),
  });
  const data = await res.json();

  if (data.status === "ok") {
    cerrarModal("modalRegistro");
    localStorage.setItem("usuario", nombre);
    actualizarBotonesUsuario(nombre);
  } else alert(data.mensaje);
}

/**
 * Inicia sesión enviando los datos al backend.
 * @async
 * @returns {Promise<void>}
 */
async function login() {
  const nombre = document.getElementById("logNombre").value.trim();
  const pass = document.getElementById("logPass").value.trim();

  if (!nombre || !pass) return alert("Completa todos los campos");

  const res = await fetch("backend/login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ nombre, contrasena: pass }),
  });
  const data = await res.json();

  if (data.status === "ok") {
    cerrarModal("modalLogin");
    localStorage.setItem("usuario", data.usuario.nombre);
    actualizarBotonesUsuario(data.usuario.nombre);
  } else alert(data.mensaje);
}

/**
 * Cierra sesión eliminando el usuario del localStorage.
 */
function logout() {
  localStorage.removeItem("usuario");
  actualizarBotonesUsuario(null);
}

/**
 * Actualiza los botones de acción según el estado del usuario.
 * @param {string|null} usuario - Nombre del usuario logueado o null si no hay usuario.
 */
function actualizarBotonesUsuario(usuario) {
  const actions = document.querySelector(".actions");
  actions.innerHTML = "";

  // Botón de tema
  const themeBtn = document.createElement("button");
  themeBtn.id = "themeToggle";
  themeBtn.title = "Cambiar tema";
  themeBtn.innerHTML = `<i class="fas ${
    document.body.classList.contains("dark") ? "fa-sun" : "fa-moon"
  }"></i>`;
  themeBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark");
    localStorage.setItem(
      "theme",
      document.body.classList.contains("dark") ? "dark" : "light"
    );
    actualizarIconoTema();
  });
  actions.appendChild(themeBtn);

  // Si el usuario está logueado
  if (usuario) {
    const btnVender = document.createElement("button");
    btnVender.className = "filled";
    btnVender.textContent = "Vender";
    btnVender.onclick = () => (window.location.href = "vender.html");
    actions.appendChild(btnVender);

    const btnLogout = document.createElement("button");
    btnLogout.className = "filled";
    btnLogout.textContent = `Cerrar sesión (${usuario})`;
    btnLogout.onclick = logout;
    actions.appendChild(btnLogout);
  } else {
    // Si no hay usuario logueado
    const btnRegistro = document.createElement("button");
    btnRegistro.className = "outline";
    btnRegistro.textContent = "Registrarse";
    btnRegistro.onclick = () => abrirModal("modalRegistro");
    actions.appendChild(btnRegistro);

    const btnLogin = document.createElement("button");
    btnLogin.className = "filled";
    btnLogin.textContent = "Iniciar sesión";
    btnLogin.onclick = () => abrirModal("modalLogin");
    actions.appendChild(btnLogin);
  }
}

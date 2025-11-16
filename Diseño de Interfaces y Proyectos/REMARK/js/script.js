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

// script.js - VERSION ADAPTADA PARA INDEX.HTML

document.addEventListener("DOMContentLoaded", () => {
  const btnBuscar = document.getElementById("btnBuscar");
  const input = document.getElementById("search");

  // Al hacer clic en Buscar desde index.html
  btnBuscar.addEventListener("click", () => {
    const texto = input.value.trim();
    if (texto.length === 0) return;

    // Redirige a la página de resultados
    window.location.href = `buscar.html?q=${encodeURIComponent(texto)}`;
  });

  // Permitir buscar con Enter
  input.addEventListener("keypress", (e) => {
    if (e.key === "Enter") btnBuscar.click();
  });

  // Abrir modales de registro y login
  document.getElementById("btnRegistro").addEventListener("click", () => {
    abrirModal("modalRegistro");
  });

  document.getElementById("btnLogin").addEventListener("click", () => {
    abrirModal("modalLogin");
  });

  // Cambio de tema
  document.getElementById("themeToggle").addEventListener("click", () => {
    document.body.classList.toggle("dark");
  });
});

// ===================================================================
// MANEJO DE MODALES
// ===================================================================
function abrirModal(id) {
  document.getElementById(id).style.display = "flex";
}

function cerrarModal(id) {
  document.getElementById(id).style.display = "none";
}

// ===================================================================
// LOGIN / REGISTRO (VERSIÓN SIMPLE PARA DEMO)
// ===================================================================
function registrar() {
  const nombre = document.getElementById("regNombre").value.trim();
  const email = document.getElementById("regEmail").value.trim();
  const pass = document.getElementById("regPass").value.trim();

  if (!nombre || !email || !pass) {
    alert("Rellena todos los campos.");
    return;
  }

  const datos = { nombre, email, pass };
  localStorage.setItem("usuario", JSON.stringify(datos));

  alert("Cuenta creada con éxito.");
  cerrarModal("modalRegistro");
}

function login() {
  const nombre = document.getElementById("logNombre").value.trim();
  const pass = document.getElementById("logPass").value.trim();

  const user = JSON.parse(localStorage.getItem("usuario"));

  if (!user || user.nombre !== nombre || user.pass !== pass) {
    alert("Credenciales incorrectas");
    return;
  }

  alert("Inicio de sesión correcto.");
  cerrarModal("modalLogin");
}

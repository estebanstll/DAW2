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

document.addEventListener("DOMContentLoaded", () => {
  mostrarResultados(PRODUCTS.slice(0, 4));
  if (localStorage.getItem("theme") === "dark")
    document.body.classList.add("dark");
  actualizarIconoTema();

  const usuario = localStorage.getItem("usuario");
  actualizarBotonesUsuario(usuario);
});

// Mostrar resultados
function mostrarResultados(lista) {
  const contenedor = document.getElementById("results");
  contenedor.innerHTML = "";
  if (lista.length === 0)
    return (contenedor.innerHTML = "<p>No se encontraron resultados.</p>");
  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");
    card.innerHTML = `<img src="${p.imagen}" alt="${p.nombre}"><h3>${p.nombre}</h3><p><strong>${p.precio} €</strong></p>`;
    contenedor.appendChild(card);
  });
}

// Búsqueda
document.getElementById("btnBuscar").addEventListener("click", () => {
  const query = document.getElementById("search").value.trim().toLowerCase();
  if (!query) return;
  const resultados = PRODUCTS.filter(
    (p) =>
      p.nombre.toLowerCase().includes(query) ||
      p.categoria.toLowerCase().includes(query)
  );
  mostrarResultados(resultados);
});

// Categorías
document.querySelectorAll(".category").forEach((cat) => {
  cat.addEventListener("click", () => {
    const resultados = PRODUCTS.filter((p) => p.categoria === cat.dataset.cat);
    mostrarResultados(resultados);
  });
});

// Tema
const themeBtn = document.getElementById("themeToggle");
function actualizarIconoTema() {
  const icon = themeBtn.querySelector("i");
  icon.classList.toggle("fa-sun", document.body.classList.contains("dark"));
  icon.classList.toggle("fa-moon", !document.body.classList.contains("dark"));
}
themeBtn?.addEventListener("click", () => {
  document.body.classList.toggle("dark");
  localStorage.setItem(
    "theme",
    document.body.classList.contains("dark") ? "dark" : "light"
  );
  actualizarIconoTema();
});

// Modales
function abrirModal(id) {
  document.getElementById(id).style.display = "flex";
}
function cerrarModal(id) {
  document.getElementById(id).style.display = "none";
}

// Registro/Login
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

function logout() {
  localStorage.removeItem("usuario");
  actualizarBotonesUsuario(null);
}

// Botones dinámicos según usuario
function actualizarBotonesUsuario(usuario) {
  const actions = document.querySelector(".actions");
  actions.innerHTML = "";

  // Botón tema
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

  // Usuario logueado
  if (usuario) {
    // --- BOTÓN VENDER ---
    const btnVender = document.createElement("button");
    btnVender.className = "filled";
    btnVender.textContent = "Vender";
    btnVender.onclick = () => (window.location.href = "vender.html");
    actions.appendChild(btnVender);

    // --- BOTÓN CERRAR SESIÓN ---
    const btnLogout = document.createElement("button");
    btnLogout.className = "filled";
    btnLogout.textContent = `Cerrar sesión (${usuario})`;
    btnLogout.onclick = logout;
    actions.appendChild(btnLogout);
  } else {
    // No logueado
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

//mas cosas

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
});

document.getElementById("btnBuscar").addEventListener("click", () => {
  const query = document.getElementById("search").value.trim();
  if (query) {
    window.location.href = `buscar.html?q=${encodeURIComponent(query)}`;
  }
});

document.querySelectorAll(".category").forEach((cat) => {
  cat.addEventListener("click", () => buscarProductos(cat.dataset.cat));
});

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

function buscarProductos(query) {
  query = query.toLowerCase();
  const resultados = PRODUCTS.filter(
    (p) =>
      p.nombre.toLowerCase().includes(query) ||
      p.categoria.toLowerCase().includes(query)
  );
  mostrarResultados(resultados);
}

function scrollToSearch() {
  document.getElementById("busqueda").scrollIntoView({ behavior: "smooth" });
}

// Tema (modo claro/oscuro)
const themeBtn = document.getElementById("themeToggle");
themeBtn.addEventListener("click", () => {
  document.body.classList.toggle("dark");
  localStorage.setItem(
    "theme",
    document.body.classList.contains("dark") ? "dark" : "light"
  );
  actualizarIconoTema();
});

function actualizarIconoTema() {
  const icon = themeBtn.querySelector("i");
  icon.classList.toggle("fa-sun", document.body.classList.contains("dark"));
  icon.classList.toggle("fa-moon", !document.body.classList.contains("dark"));
}

// Modales (registro/login)
document.getElementById("btnRegistro").onclick = () =>
  abrirModal("modalRegistro");
document.getElementById("btnLogin").onclick = () => abrirModal("modalLogin");

function abrirModal(id) {
  document.getElementById(id).style.display = "flex";
}

function cerrarModal(id) {
  document.getElementById(id).style.display = "none";
}

// Registro
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
  } else {
    alert(data.mensaje);
  }
}

// Login
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
  } else {
    alert(data.mensaje);
  }
}

// Cerrar sesión
function logout() {
  localStorage.removeItem("usuario");
  actualizarBotonesUsuario(null);
}

// UI: actualizar botones según estado de usuario
function actualizarBotonesUsuario(usuario) {
  const actions = document.querySelector(".actions");
  actions.innerHTML = "";

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

  if (usuario) {
    // Si hay usuario logueado, mostramos el botón de logout
    const btnLogout = document.createElement("button");
    btnLogout.className = "filled";
    btnLogout.textContent = `Cerrar sesión (${usuario})`;
    btnLogout.onclick = logout;
    actions.appendChild(btnLogout);
  } else {
    // Si no hay usuario, mostramos los botones normales
    const btnRegistro = document.createElement("button");
    btnRegistro.id = "btnRegistro";
    btnRegistro.className = "outline";
    btnRegistro.textContent = "Registrarse";
    btnRegistro.onclick = () => abrirModal("modalRegistro");

    const btnLogin = document.createElement("button");
    btnLogin.id = "btnLogin";
    btnLogin.className = "filled";
    btnLogin.textContent = "Iniciar sesión";
    btnLogin.onclick = () => abrirModal("modalLogin");

    actions.appendChild(btnRegistro);
    actions.appendChild(btnLogin);
  }
}

// Auto-login (restaurar estado si hay usuario en localStorage)
document.addEventListener("DOMContentLoaded", () => {
  const usuario = localStorage.getItem("usuario");
  if (usuario) actualizarBotonesUsuario(usuario);
});

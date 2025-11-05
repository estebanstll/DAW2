// ---------- PRODUCTOS DE EJEMPLO ----------
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
  buscarProductos(query);
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

// ---------- TEMA ----------
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

// ---------- MODALES ----------
document.getElementById("btnRegistro").onclick = () =>
  abrirModal("modalRegistro");
document.getElementById("btnLogin").onclick = () => abrirModal("modalLogin");

function abrirModal(id) {
  document.getElementById(id).style.display = "flex";
}

function cerrarModal(id) {
  document.getElementById(id).style.display = "none";
}

// ---------- REGISTRO ----------
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
  alert(data.mensaje);
  if (data.ok) cerrarModal("modalRegistro");
}

// ---------- LOGIN ----------
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

  if (data.ok) {
    alert(`Bienvenido, ${data.usuario}`);
    localStorage.setItem("usuario", data.usuario);
    cerrarModal("modalLogin");
  } else {
    alert(data.mensaje);
  }
}

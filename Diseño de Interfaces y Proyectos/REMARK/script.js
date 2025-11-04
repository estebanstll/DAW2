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

// Mostrar productos destacados al inicio
document.addEventListener("DOMContentLoaded", () => {
  mostrarResultados(PRODUCTS.slice(0, 4));

  // Aplicar tema guardado
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark");
  }
  actualizarIconoTema();
});

// Búsqueda
document.getElementById("btnBuscar").addEventListener("click", () => {
  const query = document.getElementById("search").value.trim();
  buscarProductos(query);
});

// Categorías
document.querySelectorAll(".category").forEach((cat) => {
  cat.addEventListener("click", () => {
    const categoria = cat.getAttribute("data-cat");
    buscarProductos(categoria);
  });
});

// Mostrar productos
function mostrarResultados(lista) {
  const contenedor = document.getElementById("results");
  contenedor.innerHTML = "";

  if (lista.length === 0) {
    contenedor.innerHTML = "<p>No se encontraron resultados.</p>";
    return;
  }

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

// Buscar productos
function buscarProductos(query) {
  query = query.toLowerCase();
  const resultados = PRODUCTS.filter(
    (p) =>
      p.nombre.toLowerCase().includes(query) ||
      p.categoria.toLowerCase().includes(query)
  );
  mostrarResultados(resultados);
}

// Desplazamiento suave
function scrollToSearch() {
  document.getElementById("busqueda").scrollIntoView({ behavior: "smooth" });
}

// Modo oscuro/claro
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
  if (document.body.classList.contains("dark")) {
    icon.classList.replace("fa-moon", "fa-sun");
  } else {
    icon.classList.replace("fa-sun", "fa-moon");
  }
}

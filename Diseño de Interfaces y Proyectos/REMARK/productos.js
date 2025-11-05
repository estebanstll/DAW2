document.addEventListener("DOMContentLoaded", async () => {
  try {
    const res = await fetch("backend/get_products.php");
    const productos = await res.json();
    console.log("Productos cargados:", productos);

    if (!productos || productos.length === 0) {
      document.getElementById("gridProductos").innerHTML =
        "<p>No hay productos en la base de datos.</p>";
      return;
    }

    mostrarProductos(productos);
    generarFiltros(productos);
    sessionStorage.setItem("productosCache", JSON.stringify(productos));

    const rango = document.getElementById("rangoPrecio");
    rango.addEventListener("input", () => {
      document.getElementById("precioMax").textContent = `${rango.value}€`;
      aplicarFiltros();
    });
  } catch (error) {
    console.error("Error cargando productos:", error);
  }
});

function mostrarProductos(lista) {
  const grid = document.getElementById("gridProductos");
  grid.innerHTML = "";

  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");
    card.innerHTML = `
      <img src="${p.imagen}" alt="${p.nombre}">
      <h3>${p.nombre}</h3>
      <p>${p.marca}</p>
      <p>${p.precio} €</p>
    `;
    grid.appendChild(card);
  });
}

function generarFiltros(productos) {
  const categorias = [...new Set(productos.map((p) => p.categoria))];
  const marcas = [...new Set(productos.map((p) => p.marca))];

  const catDiv = document.getElementById("filtroCategorias");
  categorias.forEach((cat) => {
    const item = document.createElement("div");
    item.innerHTML = `<label><input type="checkbox" value="${cat}" onchange="aplicarFiltros()"> ${cat}</label>`;
    catDiv.appendChild(item);
  });

  const marDiv = document.getElementById("filtroMarcas");
  marcas.forEach((marca) => {
    const item = document.createElement("div");
    item.innerHTML = `<label><input type="checkbox" value="${marca}" onchange="aplicarFiltros()"> ${marca}</label>`;
    marDiv.appendChild(item);
  });
}

function aplicarFiltros() {
  const productos = JSON.parse(sessionStorage.getItem("productosCache")) || [];

  const precioMax = parseFloat(document.getElementById("rangoPrecio").value);
  const cats = Array.from(
    document.querySelectorAll("#filtroCategorias input:checked")
  ).map((i) => i.value);
  const marcas = Array.from(
    document.querySelectorAll("#filtroMarcas input:checked")
  ).map((i) => i.value);

  const filtrados = productos.filter((p) => {
    return (
      p.precio <= precioMax &&
      (cats.length === 0 || cats.includes(p.categoria)) &&
      (marcas.length === 0 || marcas.includes(p.marca))
    );
  });

  mostrarProductos(filtrados);
}

document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const query = params.get("q");

  if (query) {
    document.getElementById("inputBusqueda").value = query;
    buscarProductos(query);
  }

  document.getElementById("btnBuscar").addEventListener("click", () => {
    const q = document.getElementById("inputBusqueda").value.trim();
    if (q) buscarProductos(q);
  });
});

async function buscarProductos(query) {
  try {
    const res = await fetch(
      `backend/buscar.php?q=${encodeURIComponent(query)}`
    );
    const raw = await res.text();

    if (!res.ok) {
      console.error(`[buscar.js] Error HTTP ${res.status}`, raw);
      mostrarError("Error al consultar productos en el servidor.");
      return;
    }

    let productos;
    try {
      productos = JSON.parse(raw);
    } catch (err) {
      console.error("Error al parsear JSON:", err, raw);
      mostrarError("Respuesta inesperada del servidor.");
      return;
    }

    mostrarResultados(productos);
  } catch (error) {
    console.error("Error general:", error);
    mostrarError("No se pudieron cargar los productos.");
  }
}

function mostrarResultados(lista) {
  const contenedor = document.getElementById("gridProductos");
  contenedor.innerHTML = "";

  if (!lista || lista.length === 0) {
    contenedor.innerHTML = "<p>No se encontraron resultados.</p>";
    return;
  }

  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");

    const rutaImagen = p.imagen ? p.imagen.replace(/^REMARK\//, "") : "";
    const primeraMarca = Array.isArray(p.marca) ? p.marca[0] : p.marca || "";

    card.innerHTML = `
      <img src="${rutaImagen}" alt="${p.nombre}">
      <div class="product-info">
        <h3>${p.nombre}</h3>
        <p class="marca">${primeraMarca}</p>
        <p class="precio">${parseFloat(p.precio).toFixed(2)} €</p>
      </div>
    `;

    contenedor.appendChild(card);
  });
}

function mostrarError(msg) {
  const contenedor = document.getElementById("gridProductos");
  contenedor.innerHTML = `<p class="error">${msg}</p>`;
}

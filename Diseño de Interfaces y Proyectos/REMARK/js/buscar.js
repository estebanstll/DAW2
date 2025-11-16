// buscar.js - VERSION COMPLETA Y ACTUALIZADA

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

  document
    .getElementById("precioMinInput")
    .addEventListener("input", aplicarFiltrosBusqueda);
  document
    .getElementById("precioMaxInput")
    .addEventListener("input", aplicarFiltrosBusqueda);
});

// ===============================
// BUSCAR PRODUCTOS
// ===============================
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

    sessionStorage.setItem("resultadosBusqueda", JSON.stringify(productos));

    mostrarResultados(productos);
    generarFiltrosDesdeProductosBusqueda(productos);
  } catch (error) {
    console.error("Error general:", error);
    mostrarError("No se pudieron cargar los productos.");
  }
}

// ===============================
// MOSTRAR RESULTADOS
// ===============================
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

    const rutaImagen = p.imagen
      ? p.imagen.replace(/^REMARK\//, "")
      : "resources/defecto.jpg";
    const primeraMarca = Array.isArray(p.marca) ? p.marca[0] : p.marca || "";

    card.innerHTML = `
      <img src="${rutaImagen}" alt="${
      p.nombre
    }" onerror="this.src='resources/defecto.jpg'">
      <div class="product-info">
        <h3>${p.nombre}</h3>
        <p class="marca">${primeraMarca}</p>
        <p class="precio">${parseFloat(p.precio).toFixed(2)} €</p>
      </div>
    `;

    card.addEventListener("click", () => mostrarProductoAmpliado(p));
    contenedor.appendChild(card);
  });
}

// ===============================
// MOSTRAR ERROR
// ===============================
function mostrarError(msg) {
  document.getElementById(
    "gridProductos"
  ).innerHTML = `<p class="error">${msg}</p>`;
}

// ===============================
// MODAL DEL PRODUCTO
// ===============================
function mostrarProductoAmpliado(producto) {
  const modal = document.createElement("div");
  modal.className = "modal-producto";

  const rutaImagen = producto.imagen
    ? producto.imagen.replace(/^REMARK\//, "")
    : "resources/defecto.jpg";

  modal.innerHTML = `
    <div class="modal-contenido">
      <button class="cerrar-modal">&times;</button>
      <img src="${rutaImagen}" alt="${
    producto.nombre
  }" onerror="this.src='resources/defecto.jpg'">
      <h2>${producto.nombre}</h2>
      <p class="precio">${parseFloat(producto.precio).toFixed(2)} €</p>
      <p><strong>Categoría:</strong> ${
        producto.categoria ?? "Sin categoría"
      }</p>
      <button id="btnComprar" class="btn-comprar">Comprar ahora</button>
    </div>
  `;

  document.body.appendChild(modal);

  requestAnimationFrame(() => modal.classList.add("visible"));

  modal.querySelector(".cerrar-modal").addEventListener("click", () => {
    modal.classList.remove("visible");
    setTimeout(() => modal.remove(), 250);
  });

  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("visible");
      setTimeout(() => modal.remove(), 250);
    }
  });

  modal.querySelector("#btnComprar").addEventListener("click", () => {
    const usuario = localStorage.getItem("usuario");
    if (!usuario) {
      alert("Debes iniciar sesión para comprar.");
      modal.remove();
      abrirModal("modalLogin");
      return;
    }

    localStorage.setItem("productoSeleccionado", JSON.stringify(producto));
    window.location.href = "checkout.html";
  });
}

// ===============================
// GENERAR FILTROS
// ===============================
function generarFiltrosDesdeProductosBusqueda(productos) {
  const categoriasContainer = document.getElementById("categoriasContainer");
  const marcasContainer = document.getElementById("marcasContainer");

  const categoriasSet = new Set();
  const marcasPorCategoria = {};
  const todasMarcasSet = new Set();

  productos.forEach((p) => {
    const cat = p.categoria || "";
    if (cat) categoriasSet.add(cat);

    const marcas = Array.isArray(p.marca) ? p.marca : [];
    marcas.forEach((m) => {
      const marca = m.trim();
      if (!marca) return;
      todasMarcasSet.add(marca);
      if (cat) {
        if (!marcasPorCategoria[cat]) marcasPorCategoria[cat] = new Set();
        marcasPorCategoria[cat].add(marca);
      }
    });
  });

  categoriasContainer.innerHTML = "";
  marcasContainer.innerHTML = "";

  Array.from(categoriasSet)
    .sort()
    .forEach((cat) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${cat}"> ${cat}</label>`;
      div.querySelector("input").addEventListener("change", () => {
        actualizarMarcasSegunCategoriasBusqueda(productos, marcasPorCategoria);
        aplicarFiltrosBusqueda();
      });
      categoriasContainer.appendChild(div);
    });

  actualizarMarcasSegunCategoriasBusqueda(productos, marcasPorCategoria);
}

// ===============================
// MARCAS SEGÚN CATEGORÍAS
// ===============================
function actualizarMarcasSegunCategoriasBusqueda(
  productos,
  marcasPorCategoria
) {
  const marcasContainer = document.getElementById("marcasContainer");
  const selectedCats = Array.from(
    document.querySelectorAll("#categoriasContainer input:checked")
  ).map((i) => i.value);

  const previouslyChecked = new Set(
    Array.from(document.querySelectorAll("#marcasContainer input:checked")).map(
      (i) => i.value
    )
  );

  let marcasToShow = new Set();

  if (selectedCats.length === 0) {
    productos.forEach((p) => {
      const marcas = Array.isArray(p.marca) ? p.marca : [];
      marcas.forEach((m) => marcasToShow.add(m));
    });
  } else {
    selectedCats.forEach((cat) => {
      const set = marcasPorCategoria[cat];
      if (set && set.size) set.forEach((m) => marcasToShow.add(m));
    });
  }

  selectedCats.forEach((cat) => marcasToShow.delete(cat));

  marcasContainer.innerHTML = "";
  Array.from(marcasToShow)
    .sort()
    .forEach((marca) => {
      const checked = previouslyChecked.has(marca) ? "checked" : "";
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${marca}" ${checked}> ${marca}</label>`;
      div
        .querySelector("input")
        .addEventListener("change", aplicarFiltrosBusqueda);
      marcasContainer.appendChild(div);
    });
}

// ===============================
// APLICAR FILTROS
// ===============================
function aplicarFiltrosBusqueda() {
  const productos =
    JSON.parse(sessionStorage.getItem("resultadosBusqueda")) || [];

  const minPrecio =
    parseFloat(document.getElementById("precioMinInput").value) || 0;
  const maxPrecio =
    parseFloat(document.getElementById("precioMaxInput").value) || 999999;
  const cats = Array.from(
    document.querySelectorAll("#categoriasContainer input:checked")
  ).map((i) => i.value);
  const marcas = Array.from(
    document.querySelectorAll("#marcasContainer input:checked")
  ).map((i) => i.value);

  const filtrados = productos.filter((p) => {
    const pMarcas = Array.isArray(p.marca) ? p.marca : [];
    const precioOk = p.precio >= minPrecio && p.precio <= maxPrecio;
    const catOk = cats.length === 0 || cats.includes(p.categoria);
    const marcaOk =
      marcas.length === 0 || pMarcas.some((m) => marcas.includes(m));
    return precioOk && catOk && marcaOk;
  });

  mostrarResultados(filtrados);
}

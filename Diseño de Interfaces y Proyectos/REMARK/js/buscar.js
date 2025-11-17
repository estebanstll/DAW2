document.addEventListener("DOMContentLoaded", () => {
  // Obtener parámetro 'q' de la URL
  const params = new URLSearchParams(window.location.search);
  const query = params.get("q");

  if (query) {
    // Mostrar la búsqueda en el input
    document.getElementById("inputBusqueda").value = query;
    buscarProductos(query); // Ejecutar búsqueda inicial
  }

  // Listener botón Buscar
  document.getElementById("btnBuscar").addEventListener("click", () => {
    const q = document.getElementById("inputBusqueda").value.trim();
    if (q) buscarProductos(q);
  });

  // Listeners de inputs de precio
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
/**
 * Realiza la búsqueda de productos en el backend según query.
 * @param {string} query - Texto a buscar.
 */
async function buscarProductos(query) {
  try {
    const res = await fetch(
      `backend/buscar.php?q=${encodeURIComponent(query)}`
    );
    const raw = await res.text();

    // Manejo de error HTTP
    if (!res.ok) {
      console.error(`[buscar.js] Error HTTP ${res.status}`, raw);
      mostrarError("Error al consultar productos en el servidor.");
      return;
    }

    let productos;
    try {
      productos = JSON.parse(raw); // Parsear JSON recibido
    } catch (err) {
      console.error("Error al parsear JSON:", err, raw);
      mostrarError("Respuesta inesperada del servidor.");
      return;
    }

    // Guardar resultados en sessionStorage para filtros
    sessionStorage.setItem("resultadosBusqueda", JSON.stringify(productos));

    mostrarResultados(productos); // Mostrar productos
    generarFiltrosDesdeProductosBusqueda(productos); // Crear filtros dinámicos
  } catch (error) {
    console.error("Error general:", error);
    mostrarError("No se pudieron cargar los productos.");
  }
}

// ===============================
// MOSTRAR RESULTADOS
// ===============================
/**
 * Muestra los productos en el grid.
 * @param {Array} lista - Lista de productos.
 */
function mostrarResultados(lista) {
  const contenedor = document.getElementById("gridProductos");
  contenedor.innerHTML = "";

  // Mensaje si no hay resultados
  if (!lista || lista.length === 0) {
    contenedor.innerHTML = "<p>No se encontraron resultados.</p>";
    return;
  }

  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");

    // Determinar ruta de imagen o defecto
    const rutaImagen = p.imagen
      ? p.imagen.replace(/^REMARK\//, "")
      : "resources/defecto.jpg";

    // Tomar la primera marca si existe
    const primeraMarca = Array.isArray(p.marca) ? p.marca[0] : p.marca || "";

    // Contenido HTML de la tarjeta
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

    // Abrir modal al hacer click
    card.addEventListener("click", () => mostrarProductoAmpliado(p));
    contenedor.appendChild(card);
  });
}

// ===============================
// MOSTRAR ERROR
// ===============================
function mostrarError(msg) {
  // Mostrar mensaje de error en el contenedor de productos
  document.getElementById(
    "gridProductos"
  ).innerHTML = `<p class="error">${msg}</p>`;
}

// ===============================
// MODAL DEL PRODUCTO
// ===============================
/**
 * Muestra un modal con detalles del producto y opción de compra.
 * @param {Object} producto - Producto seleccionado.
 */
function mostrarProductoAmpliado(producto) {
  const modal = document.createElement("div");
  modal.className = "modal-producto";

  // Imagen del producto o defecto
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

  // Cerrar modal al hacer click en la X
  modal.querySelector(".cerrar-modal").addEventListener("click", () => {
    modal.classList.remove("visible");
    setTimeout(() => modal.remove(), 250); // Espera animación
  });

  // Cerrar modal al click fuera del contenido
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("visible");
      setTimeout(() => modal.remove(), 250);
    }
  });

  // Botón comprar
  modal.querySelector("#btnComprar").addEventListener("click", () => {
    const usuario = localStorage.getItem("usuario");

    // Verificar usuario logueado
    if (!usuario) {
      alert("Debes iniciar sesión para comprar.");
      modal.remove();
      abrirModal("modalLogin");
      return;
    }

    // Guardar producto y redirigir a checkout
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

  // Limpiar contenedores
  categoriasContainer.innerHTML = "";
  marcasContainer.innerHTML = "";

  // Crear checkboxes de categorías
  Array.from(categoriasSet)
    .sort()
    .forEach((cat) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${cat}"> ${cat}</label>`;
      div.querySelector("input").addEventListener("change", () => {
        actualizarMarcasSegunCategoriasBusqueda(productos, marcasPorCategoria);
        aplicarFiltrosBusqueda(); // Reaplicar filtros
      });
      categoriasContainer.appendChild(div);
    });

  // Inicializar marcas según categorías seleccionadas
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

  // Categorías seleccionadas
  const selectedCats = Array.from(
    document.querySelectorAll("#categoriasContainer input:checked")
  ).map((i) => i.value);

  // Marcas previamente seleccionadas
  const previouslyChecked = new Set(
    Array.from(document.querySelectorAll("#marcasContainer input:checked")).map(
      (i) => i.value
    )
  );

  let marcasToShow = new Set();

  if (selectedCats.length === 0) {
    // Si no hay categoría, mostrar todas las marcas
    productos.forEach((p) => {
      const marcas = Array.isArray(p.marca) ? p.marca : [];
      marcas.forEach((m) => marcasToShow.add(m));
    });
  } else {
    // Si hay categorías, mostrar solo marcas asociadas
    selectedCats.forEach((cat) => {
      const set = marcasPorCategoria[cat];
      if (set && set.size) set.forEach((m) => marcasToShow.add(m));
    });
  }

  // Evitar que se muestren como marca los nombres de las categorías
  selectedCats.forEach((cat) => marcasToShow.delete(cat));

  marcasContainer.innerHTML = "";
  // Crear checkboxes de marcas
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

  // Categorías y marcas seleccionadas
  const cats = Array.from(
    document.querySelectorAll("#categoriasContainer input:checked")
  ).map((i) => i.value);
  const marcas = Array.from(
    document.querySelectorAll("#marcasContainer input:checked")
  ).map((i) => i.value);

  // Filtrar productos
  const filtrados = productos.filter((p) => {
    const pMarcas = Array.isArray(p.marca) ? p.marca : [];
    const precioOk = p.precio >= minPrecio && p.precio <= maxPrecio;
    const catOk = cats.length === 0 || cats.includes(p.categoria);
    const marcaOk =
      marcas.length === 0 || pMarcas.some((m) => marcas.includes(m));
    return precioOk && catOk && marcaOk;
  });

  mostrarResultados(filtrados); // Mostrar productos filtrados
}

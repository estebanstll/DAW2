/**
 * Evento principal que se ejecuta al cargar la página.
 * - Carga productos desde el backend.
 * - Maneja errores de red o de parsing.
 * - Muestra productos y genera filtros dinámicos.
 * - Inicializa el listener del rango de precio.
 */
document.addEventListener("DOMContentLoaded", async () => {
  try {
    // Solicitar productos al servidor
    const res = await fetch("backend/get_products.php");
    const raw = await res.text();

    // Manejo de errores HTTP
    if (!res.ok) {
      document.getElementById("gridProductos").innerHTML =
        "<p>Error cargando productos desde el servidor.</p>";
      console.error("Error HTTP:", res.status, raw);
      return;
    }

    let productos;
    try {
      productos = JSON.parse(raw); // Parsear JSON recibido
    } catch (err) {
      console.error("Error parseando JSON:", err, raw);
      document.getElementById("gridProductos").innerHTML =
        "<p>Respuesta inesperada del servidor.</p>";
      return;
    }

    // Verificar si hay productos disponibles
    if (!productos || productos.length === 0) {
      document.getElementById("gridProductos").innerHTML =
        "<p>No hay productos disponibles.</p>";
      await cargarFiltrosDesdeBD(); // Cargar filtros si no hay productos
      return;
    }

    // Mostrar productos y generar filtros
    mostrarProductos(productos);
    generarFiltrosDesdeProductos(productos);

    // Guardar productos en sessionStorage para filtros
    sessionStorage.setItem("productosCache", JSON.stringify(productos));

    // Listener para actualizar precio máximo
    const rango = document.getElementById("rangoPrecio");
    rango.addEventListener("input", () => {
      document.getElementById("precioMax").textContent = `${rango.value}€`;
      aplicarFiltros();
    });
  } catch (error) {
    console.error("Error general al cargar productos:", error);
  }
});

/* ============================================================
   MOSTRAR PRODUCTOS
============================================================ */

/**
 * Crea y muestra tarjetas de productos en la sección principal.
 * @param {Array} lista - Lista de productos a mostrar.
 * @returns {void}
 */
function mostrarProductos(lista) {
  const grid = document.getElementById("gridProductos");
  grid.innerHTML = "";

  // Mensaje si no hay productos
  if (!lista || lista.length === 0) {
    grid.innerHTML = "<p>No se encontraron productos.</p>";
    return;
  }

  // Crear tarjeta de cada producto
  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");

    // Manejo de imagen por defecto
    const rutaImagen = p.imagen
      ? p.imagen.replace(/^REMARK\//, "")
      : "resources/defecto.jpg";

    const primeraMarca =
      Array.isArray(p.marca) && p.marca.length ? p.marca[0] : "";

    // HTML interno de la tarjeta
    card.innerHTML = `
      <img src="${rutaImagen}" alt="${p.nombre}" 
           onerror="this.src='resources/defecto.jpg'">
      <div class="product-info">
        <h3>${p.nombre}</h3>
        <p class="marca">${primeraMarca}</p>
        <p class="precio">${parseFloat(p.precio).toFixed(2)} €</p>
      </div>
    `;

    // Abrir modal al hacer click
    card.addEventListener("click", () => mostrarProductoAmpliado(p));
    grid.appendChild(card);
  });
}

/* ============================================================
   MODAL DE PRODUCTO AMPLIADO
============================================================ */

/**
 * Muestra un modal con información detallada de un producto.
 * @param {Object} producto - Objeto con la información del producto.
 * @property {string} producto.nombre - Nombre del producto.
 * @property {number} producto.precio - Precio del producto.
 * @property {string} producto.categoria - Categoría del producto.
 * @property {Array} [producto.marca] - Lista de marcas asociadas.
 * @property {string} [producto.imagen] - URL de la imagen del producto.
 */
function mostrarProductoAmpliado(producto) {
  const modal = document.createElement("div");
  modal.className = "modal-producto";

  const rutaImagen = producto.imagen
    ? producto.imagen.replace(/^REMARK\//, "")
    : "resources/defecto.jpg";

  modal.innerHTML = `
    <div class="modal-contenido">
      <button class="cerrar-modal">&times;</button>
      <img src="${rutaImagen}" alt="${producto.nombre}" 
           onerror="this.src='resources/defecto.jpg'">
      <h2>${producto.nombre}</h2>
      <p class="precio">${parseFloat(producto.precio).toFixed(2)} €</p>
      <p><strong>Categoría:</strong> ${producto.categoria}</p>
      <button id="btnComprar" class="btn-comprar">Comprar ahora</button>
    </div>
  `;

  document.body.appendChild(modal);
  requestAnimationFrame(() => modal.classList.add("visible"));

  // Cerrar modal al hacer click en la X
  modal.querySelector(".cerrar-modal").addEventListener("click", () => {
    modal.classList.remove("visible");
    setTimeout(() => modal.remove(), 250);
  });

  // Cerrar modal al hacer click fuera del contenido
  modal.addEventListener("click", (e) => {
    if (e.target === modal) {
      modal.classList.remove("visible");
      setTimeout(() => modal.remove(), 250);
    }
  });

  // Botón comprar
  modal.querySelector("#btnComprar").addEventListener("click", () => {
    const usuario = localStorage.getItem("usuario");

    // Si no está logueado, abrir modal de login
    if (!usuario) {
      alert("Debes iniciar sesión para comprar.");
      modal.remove();
      abrirModal("modalLogin");
      return;
    }

    // Guardar producto seleccionado y redirigir a checkout
    localStorage.setItem("productoSeleccionado", JSON.stringify(producto));
    window.location.href = "checkout.html";
  });
}

/* ============================================================
   FILTROS DINÁMICOS
============================================================ */

/**
 * Genera filtros dinámicos de categorías y marcas según productos.
 * @param {Array} productos - Lista de productos.
 */
function generarFiltrosDesdeProductos(productos) {
  const categoriasContainer = document.getElementById("categoriasContainer");
  const marcasContainer = document.getElementById("marcasContainer");

  const categoriasSet = new Set();
  const marcasPorCategoria = {};
  const todasMarcasSet = new Set();

  // Recorrer productos y registrar categorías y marcas
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
        actualizarMarcasSegunCategorias(productos, marcasPorCategoria);
        aplicarFiltros();
      });
      categoriasContainer.appendChild(div);
    });

  // Crear checkboxes de marcas
  Array.from(todasMarcasSet)
    .sort()
    .forEach((marca) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${marca}"> ${marca}</label>`;
      div.querySelector("input").addEventListener("change", aplicarFiltros);
      marcasContainer.appendChild(div);
    });
}

/**
 * Actualiza la lista de marcas disponibles según categorías seleccionadas.
 * @param {Array} productos - Lista de productos.
 * @param {Object} marcasPorCategoria - Mapa de marcas por categoría.
 */
function actualizarMarcasSegunCategorias(productos, marcasPorCategoria) {
  const marcasContainer = document.getElementById("marcasContainer");

  const selectedCats = Array.from(
    document.querySelectorAll("#filtroCategorias input:checked")
  ).map((i) => i.value);

  const allCats = new Set(
    Array.from(document.querySelectorAll("#filtroCategorias input")).map(
      (i) => i.value
    )
  );

  const previouslyChecked = new Set(
    Array.from(document.querySelectorAll("#filtroMarcas input:checked")).map(
      (i) => i.value
    )
  );

  let marcasToShow = new Set();

  // Lógica para decidir qué marcas mostrar
  if (selectedCats.length === 0) {
    productos.forEach((p) => {
      const marcas = Array.isArray(p.marca) ? p.marca : [];
      marcas.forEach((m) => {
        if (!allCats.has(m)) marcasToShow.add(m);
      });
    });
  } else {
    selectedCats.forEach((cat) => {
      const set = marcasPorCategoria[cat];
      if (set) {
        set.forEach((m) => {
          if (!allCats.has(m)) marcasToShow.add(m);
        });
      }
    });
  }

  // Limpiar contenedor y crear checkboxes
  marcasContainer.innerHTML = "";

  if (marcasToShow.size === 0) {
    marcasContainer.innerHTML = "<p>No hay marcas.</p>";
    return;
  }

  Array.from(marcasToShow)
    .sort()
    .forEach((marca) => {
      const checked = previouslyChecked.has(marca) ? "checked" : "";
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${marca}" ${checked}> ${marca}</label>`;
      div.querySelector("input").addEventListener("change", aplicarFiltros);
      marcasContainer.appendChild(div);
    });
}

/**
 * Carga filtros desde la base de datos si no hay productos cargados.
 * @async
 */
async function cargarFiltrosDesdeBD() {
  try {
    const [catRes, marRes] = await Promise.all([
      fetch("backend/get_categories.php"),
      fetch("backend/get_brands.php"),
    ]);

    const [catRaw, marRaw] = await Promise.all([catRes.text(), marRes.text()]);
    const categorias = JSON.parse(catRaw);
    const marcas = JSON.parse(marRaw);

    const catCont = document.getElementById("categoriasContainer");
    const marCont = document.getElementById("marcasContainer");

    catCont.innerHTML = "";
    marCont.innerHTML = "";

    categorias.forEach((cat) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${cat}" onchange="aplicarFiltros()"> ${cat}</label>`;
      catCont.appendChild(div);
    });

    marcas.forEach((marca) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${marca}" onchange="aplicarFiltros()"> ${marca}</label>`;
      marCont.appendChild(div);
    });
  } catch (error) {
    console.error("Error cargando filtros desde la BD:", error);
  }
}

/**
 * Filtra productos según precio, categorías y marcas seleccionadas.
 */
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
    const pMarcas = Array.isArray(p.marca) ? p.marca : [];
    return (
      p.precio <= precioMax &&
      (cats.length === 0 || cats.includes(p.categoria)) &&
      (marcas.length === 0 || pMarcas.some((m) => marcas.includes(m)))
    );
  });

  mostrarProductos(filtrados);
}

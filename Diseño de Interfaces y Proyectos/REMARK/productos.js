document.addEventListener("DOMContentLoaded", async () => {
  try {
    const res = await fetch("backend/get_products.php");
    const raw = await res.text();

    if (!res.ok) {
      document.getElementById("gridProductos").innerHTML =
        "<p>Error cargando productos desde el servidor.</p>";
      console.error("Error HTTP:", res.status, raw);
      return;
    }

    let productos;
    try {
      productos = JSON.parse(raw);
    } catch (err) {
      console.error("Error parseando JSON:", err, raw);
      document.getElementById("gridProductos").innerHTML =
        "<p>Respuesta inesperada del servidor.</p>";
      return;
    }

    if (!productos || productos.length === 0) {
      document.getElementById("gridProductos").innerHTML =
        "<p>No hay productos disponibles.</p>";
      await cargarFiltrosDesdeBD();
      return;
    }

    mostrarProductos(productos);
    generarFiltrosDesdeProductos(productos);
    sessionStorage.setItem("productosCache", JSON.stringify(productos));

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
   FUNCIÓN PRINCIPAL: MOSTRAR PRODUCTOS
============================================================ */
function mostrarProductos(lista) {
  const grid = document.getElementById("gridProductos");
  grid.innerHTML = "";

  if (!lista || lista.length === 0) {
    grid.innerHTML = "<p>No se encontraron productos.</p>";
    return;
  }

  lista.forEach((p) => {
    const card = document.createElement("div");
    card.classList.add("product-card");

    // ✅ Corregir ruta de imagen
    const rutaImagen = p.imagen
      ? p.imagen.replace(/^REMARK\//, "")
      : "resources/defecto.jpg";

    const primeraMarca =
      Array.isArray(p.marca) && p.marca.length ? p.marca[0] : "";

    card.innerHTML = `
      <img src="${rutaImagen}" alt="${p.nombre}" 
           onerror="this.src='resources/defecto.jpg'">
      <div class="product-info">
        <h3>${p.nombre}</h3>
        <p class="marca">${primeraMarca}</p>
        <p class="precio">${parseFloat(p.precio).toFixed(2)} €</p>
      </div>
    `;

    // ✅ Abrir modal al hacer clic
    card.addEventListener("click", () => mostrarProductoAmpliado(p));
    grid.appendChild(card);
  });
}

/* ============================================================
   MODAL DE PRODUCTO AMPLIADO
============================================================ */
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

  // 🟢 Forzar render y luego mostrar con transición
  requestAnimationFrame(() => {
    modal.classList.add("visible");
  });

  // Cerrar al hacer clic en el botón
  modal.querySelector(".cerrar-modal").addEventListener("click", () => {
    modal.classList.remove("visible");
    setTimeout(() => modal.remove(), 250); // Espera transición
  });

  // Cerrar al hacer clic fuera del contenido
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

/* ============================================================
   FILTROS DINÁMICOS
============================================================ */
function generarFiltrosDesdeProductos(productos) {
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
        actualizarMarcasSegunCategorias(productos, marcasPorCategoria);
        aplicarFiltros();
      });
      categoriasContainer.appendChild(div);
    });

  Array.from(todasMarcasSet)
    .sort()
    .forEach((marca) => {
      const div = document.createElement("div");
      div.innerHTML = `<label><input type="checkbox" value="${marca}"> ${marca}</label>`;
      div.querySelector("input").addEventListener("change", aplicarFiltros);
      marcasContainer.appendChild(div);
    });
}

function actualizarMarcasSegunCategorias(productos, marcasPorCategoria) {
  const marcasContainer = document.getElementById("marcasContainer");
  const selectedCats = Array.from(
    document.querySelectorAll("#filtroCategorias input:checked")
  ).map((i) => i.value);

  const previouslyChecked = new Set(
    Array.from(document.querySelectorAll("#filtroMarcas input:checked")).map(
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

  marcasContainer.innerHTML = "";
  Array.from(marcasToShow)
    .sort()
    .forEach((marca) => {
      const div = document.createElement("div");
      const checked = previouslyChecked.has(marca) ? "checked" : "";
      div.innerHTML = `<label><input type="checkbox" value="${marca}" ${checked}> ${marca}</label>`;
      div.querySelector("input").addEventListener("change", aplicarFiltros);
      marcasContainer.appendChild(div);
    });
}

/* ============================================================
   CARGAR FILTROS DESDE LA BASE DE DATOS (SI FALLA FETCH)
============================================================ */
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

/* ============================================================
   APLICAR FILTROS
============================================================ */
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

/*
  productos.js - comportamiento
  - solicita /backend/get_products.php para obtener todos los productos
  - muestra los productos en #gridProductos
  - solicita /backend/get_categories.php y /backend/get_brands.php para poblar los filtros
  - aplicarFiltros() filtra en el cliente usando sessionStorage (productosCache)
  Debug: este archivo imprime trazas en consola para ayudar al diagnóstico.
*/

document.addEventListener("DOMContentLoaded", async () => {
  try {
    console.log(
      "[productos.js] Iniciando carga de productos desde backend/get_products.php..."
    );
    const res = await fetch("backend/get_products.php");

    console.log(
      `[productos.js] get_products.php -> status: ${res.status} ${res.statusText}`
    );

    // Leer el body como texto una sola vez (evita "body already used")
    const raw = await res.text();

    if (!res.ok) {
      console.error(
        `get_products.php HTTP error: ${res.status} ${res.statusText}`
      );
      console.error("Respuesta del servidor:", raw);
      document.getElementById("gridProductos").innerHTML =
        "<p>Error cargando productos desde el servidor.</p>";
      return;
    }

    // intentar parsear JSON a partir del texto recibido
    let productos;
    try {
      productos = JSON.parse(raw);
    } catch (parseErr) {
      console.error("No se pudo parsear JSON de get_products.php:", parseErr);
      console.error("Respuesta cruda:", raw);
      document.getElementById("gridProductos").innerHTML =
        "<p>Respuesta inesperada del servidor al solicitar productos.</p>";
      return;
    }

    console.log("[productos.js] Productos cargados (array):", productos);

    if (!productos || productos.length === 0) {
      console.warn("[productos.js] No se encontraron productos en la BBDD.");
      document.getElementById("gridProductos").innerHTML =
        "<p>No hay productos en la base de datos.</p>";
      // Aún intentamos cargar filtros para ver si hay categorías/marcas
      await cargarFiltrosDesdeBD();
      return;
    }

    mostrarProductos(productos);
    // generar filtros dinámicamente a partir de los productos cargados
    console.log(
      "[productos.js] Generando filtros de categorías y marcas desde los productos..."
    );
    generarFiltrosDesdeProductos(productos);
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
  // Esta función ya no se usa; los filtros se cargan desde la BBDD
}

/**
 * Genera los checkboxes de categorías y marcas a partir del array de productos
 * y establece la relación para que las marcas se filtren según categorías seleccionadas.
 */
function generarFiltrosDesdeProductos(productos) {
  const categoriasContainer = document.getElementById("categoriasContainer");
  const marcasContainer = document.getElementById("marcasContainer");

  // construir conjunto de categorías y mapa de categoria -> set de marcas
  const categoriasSet = new Set();
  const marcasPorCategoria = {};
  const todasMarcasSet = new Set();

  productos.forEach((p) => {
    const cat = p.categoria || "";
    const marca = (p.marca || "").trim();
    if (cat) {
      categoriasSet.add(cat);
      if (!marcasPorCategoria[cat]) marcasPorCategoria[cat] = new Set();
      if (marca) {
        marcasPorCategoria[cat].add(marca);
        todasMarcasSet.add(marca);
      }
    } else if (marca) {
      // productos sin categoria explícita -> añadir marca a global
      todasMarcasSet.add(marca);
    }
  });

  // limpiar contenedores
  categoriasContainer.innerHTML = "";
  marcasContainer.innerHTML = "";

  // crear checkbox para cada categoría
  Array.from(categoriasSet)
    .sort()
    .forEach((cat) => {
      const div = document.createElement("div");
      const id = `cat_${cat.replace(/\s+/g, "_")}`;
      div.innerHTML = `<label><input type="checkbox" id="${id}" value="${cat}"> ${cat}</label>`;
      categoriasContainer.appendChild(div);
      // attach change handler
      const input = div.querySelector("input");
      input.addEventListener("change", () => {
        actualizarMarcasSegunCategorias(productos, marcasPorCategoria);
        aplicarFiltros();
      });
    });

  // inicialmente mostrar todas las marcas
  const todasMarcas = Array.from(todasMarcasSet).sort();
  todasMarcas.forEach((marca) => {
    const div = document.createElement("div");
    div.innerHTML = `<label><input type="checkbox" value="${marca}"> ${marca}</label>`;
    // attach handler
    div.querySelector("input").addEventListener("change", aplicarFiltros);
    marcasContainer.appendChild(div);
  });
}

/**
 * Actualiza el listado de marcas mostrado según las categorías seleccionadas.
 * Si no hay categorías seleccionadas, muestra todas las marcas.
 */
function actualizarMarcasSegunCategorias(productos, marcasPorCategoria) {
  const marcasContainer = document.getElementById("marcasContainer");
  const selectedCats = Array.from(
    document.querySelectorAll("#filtroCategorias input:checked")
  ).map((i) => i.value);

  // recordar marcas seleccionadas actualmente para reaplicar si siguen disponibles
  const previouslyChecked = new Set(
    Array.from(document.querySelectorAll("#filtroMarcas input:checked")).map(
      (i) => i.value
    )
  );

  let marcasToShow = new Set();
  if (selectedCats.length === 0) {
    // ninguna cat seleccionada -> mostrar todas las marcas presentes en productos
    productos.forEach((p) => {
      if (p.marca) marcasToShow.add(p.marca);
    });
  } else {
    selectedCats.forEach((cat) => {
      const set = marcasPorCategoria[cat];
      if (set && set.size) {
        set.forEach((m) => marcasToShow.add(m));
      }
    });
  }

  // reconstruir marcasContainer
  marcasContainer.innerHTML = "";
  Array.from(marcasToShow)
    .sort()
    .forEach((marca) => {
      const div = document.createElement("div");
      const checked = previouslyChecked.has(marca) ? "checked" : "";
      div.innerHTML = `<label><input type="checkbox" value="${marca}" ${checked}> ${marca}</label>`;
      // attach handler to apply filters when brand changed
      div.querySelector("input").addEventListener("change", aplicarFiltros);
      marcasContainer.appendChild(div);
    });
}

/**
 * Carga categorías y marcas desde los endpoints PHP y las inserta
 * en los contenedores `#categoriasContainer` y `#marcasContainer`.
 */
async function cargarFiltrosDesdeBD() {
  try {
    console.log("[productos.js] fetch: get_categories.php y get_brands.php");
    const [catRes, marRes] = await Promise.all([
      fetch("backend/get_categories.php"),
      fetch("backend/get_brands.php"),
    ]);

    console.log(
      `[productos.js] get_categories.php status: ${catRes.status} ${catRes.statusText}`
    );
    console.log(
      `[productos.js] get_brands.php status: ${marRes.status} ${marRes.statusText}`
    );

    // Leer bodies como texto una sola vez
    const [catRaw, marRaw] = await Promise.all([catRes.text(), marRes.text()]);

    if (!catRes.ok) {
      console.error(
        "[productos.js] Error en get_categories.php:",
        catRes.status,
        catRaw
      );
    }
    if (!marRes.ok) {
      console.error(
        "[productos.js] Error en get_brands.php:",
        marRes.status,
        marRaw
      );
    }

    // parsear JSON desde los textos
    let categorias = [];
    let marcas = [];
    try {
      categorias = JSON.parse(catRaw);
    } catch (err) {
      console.error(
        "[productos.js] No se pudo parsear JSON de get_categories.php:",
        err
      );
      console.error(
        "[productos.js] Respuesta cruda get_categories.php:",
        catRaw
      );
      categorias = [];
    }
    try {
      marcas = JSON.parse(marRaw);
    } catch (err) {
      console.error(
        "[productos.js] No se pudo parsear JSON de get_brands.php:",
        err
      );
      console.error("[productos.js] Respuesta cruda get_brands.php:", marRaw);
      marcas = [];
    }

    console.log("[productos.js] Categorías recibidas:", categorias);
    console.log("[productos.js] Marcas recibidas:", marcas);

    const catCont = document.getElementById("categoriasContainer");
    const marCont = document.getElementById("marcasContainer");

    // limpiar contenedores previos
    catCont.innerHTML = "";
    marCont.innerHTML = "";

    // Poblar categorías
    if (Array.isArray(categorias)) {
      categorias.forEach((cat) => {
        const div = document.createElement("div");
        // escapar sencillo para valores
        const v = String(cat).replace(/"/g, "&quot;");
        div.innerHTML = `<label><input type="checkbox" value="${v}" onchange="aplicarFiltros()"> ${cat}</label>`;
        catCont.appendChild(div);
      });
    }

    // Poblar marcas
    if (Array.isArray(marcas)) {
      marcas.forEach((marca) => {
        const div = document.createElement("div");
        const v = String(marca).replace(/"/g, "&quot;");
        div.innerHTML = `<label><input type="checkbox" value="${v}" onchange="aplicarFiltros()"> ${marca}</label>`;
        marCont.appendChild(div);
      });
    }
    console.log(
      "[productos.js] Filtros insertados en el DOM (categorías/marcas). Fin cargarFiltrosDesdeBD()."
    );
  } catch (error) {
    console.error("[productos.js] Error cargando filtros desde BBDD:", error);
  }
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

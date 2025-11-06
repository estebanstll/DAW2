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

    const rutaImagen = p.imagen.replace(/^REMARK\//, "");

    card.innerHTML = `
      <img src="${rutaImagen}" alt="${p.nombre}">
      <div class="product-info">
        <h3>${p.nombre}</h3>
        <p class="marca">${p.marca || ""}</p>
        <p class="precio">${parseFloat(p.precio).toFixed(2)} €</p>
      </div>
    `;

    grid.appendChild(card);
  });
}

function generarFiltrosDesdeProductos(productos) {
  const categoriasContainer = document.getElementById("categoriasContainer");
  const marcasContainer = document.getElementById("marcasContainer");

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
      todasMarcasSet.add(marca);
    }
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

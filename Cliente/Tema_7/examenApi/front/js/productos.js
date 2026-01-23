const API_URL = "http://localhost:3000";

function getUserData() {
  const userData = localStorage.getItem("userData");
  return userData ? JSON.parse(userData) : null;
}

function saveUserData(userData) {
  localStorage.setItem("userData", JSON.stringify(userData));
}

function isAuthenticated() {
  return getUserData() !== null;
}

function isAdmin() {
  const user = getUserData();
  return user && user.admin === "1";
}

function logout() {
  localStorage.removeItem("userData");
  window.location.href = "index.html";
}

function formatPrice(price) {
  return new Intl.NumberFormat("es-ES", {
    style: "currency",
    currency: "EUR",
  }).format(price);
}

async function logError(message, nivel = "ERROR") {
  try {
    await fetch(`${API_URL}/logs`, {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        mensaje: `[FRONTEND] ${message}`,
        nivel,
        fecha: new Date().toISOString().split("T")[0],
      }),
    });
  } catch (error) {
    console.error("No se pudo registrar el error:", error);
  }
}

document.addEventListener("DOMContentLoaded", function () {
  // Verificar autenticación
  if (!isAuthenticated()) {
    window.location.href = "login.html";
    return;
  }

  const user = getUserData();

  // Configurar botón de logout
  const btnLogout = document.getElementById("btnLogout");
  if (btnLogout) {
    btnLogout.addEventListener("click", logout);
  }

  // Configurar formulario de producto
  const productForm = document.getElementById("productForm");
  if (productForm) {
    productForm.addEventListener("submit", handleCreateProduct);
  }

  // Mostrar botón para admin si aplica
  if (isAdmin()) {
    const topbar = document.querySelector(".topbar__actions");
    if (topbar) {
      const adminLink = document.createElement("a");
      adminLink.href = "admin.html";
      adminLink.className = "btn btn--primary";
      adminLink.textContent = "Panel Admin";
      topbar.insertBefore(adminLink, topbar.firstChild);
    }
  }

  // Cargar productos
  loadProducts();
});

/**
 * Cargar y mostrar productos
 */
async function loadProducts() {
  try {
    const user = getUserData();
    const productList = document.getElementById("productList");

    if (!productList) return;

    // Limpiar lista (excepto el demo)
    const demoProduct = productList.querySelector('[data-id="__demo__"]');
    productList.innerHTML = "";
    if (demoProduct) {
      productList.appendChild(demoProduct);
    }

    // Obtener todos los productos
    const response = await fetch("http://localhost:3000/products");

    if (!response.ok) {
      throw new Error("No se pudieron cargar los productos");
    }

    const productos = await response.json();

    // Filtrar: solo mostrar productos del usuario (o todos si es admin)
    let productosAMostrar = productos;
    if (!isAdmin()) {
      productosAMostrar = productos.filter((p) => p.user === user.nombre);
    }

    // Si no hay productos, no mostrar alertas emergentes

    // Renderizar productos
    productosAMostrar.forEach((product) => {
      renderProduct(product);
    });
  } catch (error) {
    console.error("Error cargando productos:", error);
    logError(`Error al cargar productos: ${error.message}`);
    // No mostrar alertas emergentes
  }
}

/**
 * Renderizar un producto en la lista
 */
function renderProduct(product) {
  const productList = document.getElementById("productList");

  if (!productList) return;

  const article = document.createElement("article");
  article.className = "product";
  article.dataset.id = product.id;

  const priceFormatted = formatPrice(product.price);

  article.innerHTML = `
    <div class="product__body">
      <h3 class="product__name">${escapeHtml(product.name)}</h3>
      <p class="product__desc">${escapeHtml(product.description)}</p>
      <p class="product__meta">
        <span class="badge">${priceFormatted}</span>
        <span class="muted">Creado por: <strong>${escapeHtml(product.user)}</strong></span>
      </p>
    </div>
    <div class="product__actions">
      <!-- Solo visible para admin -->
    </div>
  `;

  // Agregar botón eliminar si es admin
  if (isAdmin()) {
    const actions = article.querySelector(".product__actions");
    const deleteBtn = document.createElement("button");
    deleteBtn.className = "btn btn--danger";
    deleteBtn.type = "button";
    deleteBtn.textContent = "Eliminar";
    deleteBtn.addEventListener("click", () => deleteProduct(product.id));
    actions.appendChild(deleteBtn);
  }

  productList.appendChild(article);
}

/**
 * Manejar creación de producto
 */
async function handleCreateProduct(event) {
  event.preventDefault();

  try {
    const user = getUserData();
    const name = document.getElementById("name").value.trim();
    const description = document.getElementById("description").value.trim();
    const price = parseFloat(document.getElementById("price").value);

    // Validaciones
    if (!name || !description || isNaN(price) || price <= 0) {
      alert("Por favor completa todos los campos correctamente");
      logError("Validación fallida: campos incompletos o inválidos", "WARN");
      return;
    }

    // Crear producto
    const response = await fetch("http://localhost:3000/products", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        name: name,
        description: description,
        price: price,
        user: user.nombre,
      }),
    });

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

    const newProduct = await response.json();

    // Limpiar formulario
    document.getElementById("productForm").reset();

    logError(`Producto '${name}' creado por ${user.nombre}`, "INFO");

    // Recargar productos
    loadProducts();
  } catch (error) {
    console.error("Error creando producto:", error);
    logError(`Error al crear producto: ${error.message}`);
    // No mostrar alertas emergentes
  }
}

/**
 * Eliminar producto (solo admin)
 */
async function deleteProduct(productId) {
  if (!isAdmin()) {
    alert("No tienes permisos para eliminar productos");
    logError("Intento de eliminar producto sin permisos", "WARN");
    return;
  }

  if (!confirm("¿Estás seguro de que deseas eliminar este producto?")) {
    return;
  }

  try {
    const response = await fetch(
      `http://localhost:3000/products/${productId}`,
      {
        method: "DELETE",
        headers: { Accept: "application/json" },
      },
    );

    if (!response.ok) {
      throw new Error(`Error HTTP: ${response.status}`);
    }

    // Remover del DOM
    const article = document.querySelector(`[data-id="${productId}"]`);
    if (article) {
      article.remove();
    }

    logError(`Producto ${productId} eliminado`, "INFO");
  } catch (error) {
    console.error("Error eliminando producto:", error);
    logError(`Error al eliminar producto ${productId}: ${error.message}`);
    // No mostrar alertas emergentes
  }
}

/**
 * Escapar caracteres HTML para prevenir XSS
 */
function escapeHtml(text) {
  const map = {
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#039;",
  };
  return text.replace(/[&<>"']/g, (m) => map[m]);
}

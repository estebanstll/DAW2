/**
 * Panel de Administración - Gestionar todos los productos
 */

// Utilidades antes incluidas en utils.js (inlined aquí)
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

  // Verificar permisos de admin
  if (!isAdmin()) {
    const main = document.querySelector("main");
    if (main) {
      main.innerHTML = `
        <section class="alert" style="margin: 20px 0;">
          <p class="alert__text" style="color: #c82333; background: #fee; padding: 15px; border-radius: 5px;">
            ⛔ Acceso denegado. Solo administradores pueden acceder a este panel.
          </p>
        </section>
      `;
    }
    logError("Intento de acceso al panel admin sin permisos", "WARN");
    setTimeout(() => {
      window.location.href = "productos.html";
    }, 3000);
    return;
  }

  // Configurar botón de logout
  const btnLogout = document.getElementById("btnLogout");
  if (btnLogout) {
    btnLogout.addEventListener("click", logout);
  }

  // Cargar todos los productos
  loadAllProducts();
});

/**
 * Cargar todos los productos para el admin
 */
async function loadAllProducts() {
  try {
    const adminList = document.getElementById("adminList");

    if (!adminList) return;

    // Remover fila demo
    const demoRow = adminList.querySelector('[data-id="__demo__"]');
    if (demoRow) {
      demoRow.remove();
    }

    // Obtener todos los productos
    const response = await fetch("http://localhost:3000/products");

    if (!response.ok) {
      throw new Error("No se pudieron cargar los productos");
    }

    const productos = await response.json();

    if (productos.length === 0) {
      // No mostrar alertas emergentes; dejamos la lista vacía
      return;
    }

    // Renderizar cada producto como fila
    productos.forEach((product) => {
      renderAdminRow(product);
    });
  } catch (error) {
    console.error("Error cargando productos:", error);
    logError(`Error al cargar productos para admin: ${error.message}`);
    // No mostrar alertas emergentes
  }
}

/**
 * Renderizar una fila de producto en la tabla del admin
 */
function renderAdminRow(product) {
  const adminList = document.getElementById("adminList");

  if (!adminList) return;

  const row = document.createElement("div");
  row.className = "admin-row";
  row.dataset.id = product.id;

  const priceFormatted = formatPrice(product.price);

  row.innerHTML = `
    <span class="truncate">${escapeHtml(product.name)}</span>
    <span class="truncate">${escapeHtml(product.description)}</span>
    <span>${priceFormatted}</span>
    <span class="muted"><strong>${escapeHtml(product.user)}</strong></span>
    <span>
      <button class="btn btn--danger" type="button" data-id="${product.id}">
        Eliminar
      </button>
    </span>
  `;

  // Agregar event listener al botón de eliminar
  const deleteBtn = row.querySelector("button");
  if (deleteBtn) {
    deleteBtn.addEventListener("click", () =>
      deleteProductFromAdmin(product.id, row),
    );
  }

  adminList.appendChild(row);
}

/**
 * Eliminar producto desde el panel admin
 */
async function deleteProductFromAdmin(productId, rowElement) {
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

    // Remover fila del DOM
    if (rowElement) {
      rowElement.remove();
    }

    logError(`Producto ${productId} eliminado por admin`, "INFO");
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

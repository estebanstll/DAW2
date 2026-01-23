const API_URL = "http://localhost:3000";

async function apiCall(endpoint, options = {}) {
  const url = `${API_URL}${endpoint}`;
  const response = await fetch(url, {
    headers: {
      Accept: "application/json",
      ...options.headers,
    },
    ...options,
  });

  if (!response.ok) {
    throw new Error(`HTTP error! status: ${response.status}`);
  }

  return await response.json();
}

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

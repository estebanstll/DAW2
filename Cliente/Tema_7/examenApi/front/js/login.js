const form = document.getElementById("loginForm");

form.addEventListener("submit", async function (event) {
  event.preventDefault();

  const nombre = document.getElementById("nombre").value.trim();
  const contrasena = document.getElementById("contraseña").value;

  if (!nombre || !contrasena) {
    alert("Por favor completa todos los campos");
    return;
  }

  await loginUser(nombre, contrasena);
});

/**
 * Intentar login o crear usuario si no existe
 */
async function loginUser(nombre, contrasena) {
  try {
    // Intentar obtener el usuario existente
    const usuarioResponse = await apiCall(`/register/${nombre}`);

    if (usuarioResponse && usuarioResponse.contraseña === contrasena) {
      // Login exitoso
      saveUserData(usuarioResponse);
      logError(`Usuario '${nombre}' logueado exitosamente`, "INFO");

      // Redirigir según si es admin o no
      setTimeout(() => {
        if (usuarioResponse.admin === "1") {
          window.location.href = "admin.html";
        } else {
          window.location.href = "productos.html";
        }
      }, 500);
    } else {
      // Contraseña incorrecta
      alert("Contraseña incorrecta");
      logError(
        `Intento de login fallido para '${nombre}': contraseña incorrecta`,
        "WARN",
      );
    }
  } catch (error) {
    // Usuario no existe, intentar crear
    console.log("Usuario no encontrado, intentando crear...");
    await crearUsuario(nombre, contrasena);
  }
}

/**
 * Crear nuevo usuario
 */
async function crearUsuario(nombre, contrasena) {
  try {
    const response = await fetch("http://localhost:3000/register", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        nombre: nombre,
        contraseña: contrasena,
        admin: "0",
      }),
    });

    if (response.ok) {
      const nuevoUsuario = await response.json();
      saveUserData(nuevoUsuario);
      logError(`Nuevo usuario '${nombre}' creado`, "INFO");

      setTimeout(() => {
        window.location.href = "productos.html";
      }, 500);
    } else {
      const error = await response.text();
      alert("Error al crear el usuario: " + error);
      logError(`Error al crear usuario '${nombre}': ${error}`, "ERROR");
    }
  } catch (error) {
    console.error("Error:", error);
    alert("Error al crear el usuario");
    logError(
      `Excepción al crear usuario '${nombre}': ${error.message}`,
      "ERROR",
    );
  }
}

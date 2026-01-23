const form = document.getElementById("loginForm");

form.addEventListener("submit", function (event) {
  event.preventDefault();

  const nombre = document.getElementById("nombre").value;
  const contrasena = document.getElementById("contraseña").value;

  console.log("Datos recibidos:");
  console.log("Nombre:", nombre);
  console.log("Contraseña:", contrasena);

  async function getUsuario(nombre, contrasena) {
    try {
      // Intentar obtener el usuario
      const response = await fetch(`http://localhost:3000/usuario/${nombre}`);

      if (response.ok) {
        const usuario = await response.json();

        // Verificar si la contraseña es correcta
        if (usuario.contrasena === contrasena) {
          console.log("Login exitoso");
          window.location.href = "index.html";
        } else {
          console.log("Contraseña incorrecta");
          alert("Contraseña incorrecta");
        }
      } else {
        // Usuario no existe, crear nuevo usuario
        console.log("Usuario no encontrado, creando nuevo usuario...");
        await crearUsuario(nombre, contrasena);
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Error al procesar el login");
    }
  }

  async function crearUsuario(nombre, contrasena) {
    try {
      const response = await fetch("http://localhost:3000/usuario", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          nombre: nombre,
          contrasena: contrasena,
        }),
      });

      if (response.ok) {
        console.log("Usuario creado exitosamente");
        window.location.href = "index.html";
      } else {
        console.log("Error al crear usuario");
        alert("Error al crear el usuario");
      }
    } catch (error) {
      console.error("Error:", error);
      alert("Error al crear el usuario");
    }
  }

  getUsuario(nombre, contrasena);
});

document.addEventListener("DOMContentLoaded", () => {
  console.log("JS cargado. Leyendo usuario...");
  const usuario = localStorage.getItem("usuario"); // Obtener usuario logueado desde localStorage

  console.log("Usuario guardado:", usuario);

  if (!usuario) {
    // Si no hay usuario, bloquear publicación
    alert("Debes iniciar sesión.");
    return;
  }

  // Asociar el botón "Publicar" a la función publicarProducto
  document
    .getElementById("btnPublicar")
    .addEventListener("click", publicarProducto);
});

/**
 * Recoge datos del formulario y los envía al backend para publicar un producto
 */
function publicarProducto() {
  console.log("== Enviando formulario ==");

  const usuario = localStorage.getItem("usuario"); // Usuario logueado

  // Recoger valores del formulario
  const nombre = document.getElementById("prodNombre").value;
  const categoria = document.getElementById("prodCategoria").value;
  const descripcion = document.getElementById("prodDesc").value;
  const precio = document.getElementById("prodPrecio").value;
  const imagen = document.getElementById("prodImagen").files[0]; // Primer archivo seleccionado

  console.log("Datos recogidos:");
  console.log({ nombre, categoria, descripcion, precio, usuario, imagen });

  // Crear FormData para enviar datos incluyendo el archivo
  const formData = new FormData();
  formData.append("nombre", nombre);
  formData.append("categoria", categoria);
  formData.append("descripcion", descripcion);
  formData.append("precio", precio);
  formData.append("usuario", usuario);
  formData.append("imagen", imagen);

  console.log("Enviando fetch a backend/subir_producto.php");

  fetch("backend/subir_producto.php", {
    method: "POST",
    body: formData, // Enviar los datos del formulario
  })
    .then(async (res) => {
      console.log("Respuesta RAW:", res);

      const texto = await res.text(); // Leer respuesta como texto
      console.log("Respuesta en TEXTO:", texto);

      try {
        return JSON.parse(texto); // Intentar parsear a JSON
      } catch (e) {
        console.error("NO ES JSON. ERROR:", e);
        throw new Error("Respuesta no es JSON"); // Lanzar error si no es JSON
      }
    })
    .then((data) => {
      console.log("JSON recibido:", data);

      // Mostrar alerta según estado de la respuesta
      if (data.status === "ok") {
        alert("Producto publicado"); // Todo correcto
      } else {
        alert("Error: " + data.mensaje); // Error desde backend
      }
    })
    .catch((err) => {
      // Captura errores de red o JSON
      console.error("PETICIÓN FALLIDA:", err);
      alert("Fallo al conectar con el servidor.");
    });
}

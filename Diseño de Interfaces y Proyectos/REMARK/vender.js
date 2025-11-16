document.addEventListener("DOMContentLoaded", () => {
  console.log("JS cargado. Leyendo usuario...");
  const usuario = localStorage.getItem("usuario");

  console.log("Usuario guardado:", usuario);

  if (!usuario) {
    alert("Debes iniciar sesión.");
    return;
  }

  document
    .getElementById("btnPublicar")
    .addEventListener("click", publicarProducto);
});

function publicarProducto() {
  console.log("== Enviando formulario ==");

  const usuario = localStorage.getItem("usuario");

  const nombre = document.getElementById("prodNombre").value;
  const categoria = document.getElementById("prodCategoria").value;
  const descripcion = document.getElementById("prodDesc").value;
  const precio = document.getElementById("prodPrecio").value;
  const imagen = document.getElementById("prodImagen").files[0];

  console.log("Datos recogidos:");
  console.log({ nombre, categoria, descripcion, precio, usuario, imagen });

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
    body: formData,
  })
    .then(async (res) => {
      console.log("Respuesta RAW:", res);

      const texto = await res.text();
      console.log("Respuesta en TEXTO:", texto);

      try {
        return JSON.parse(texto);
      } catch (e) {
        console.error("NO ES JSON. ERROR:", e);
        throw new Error("Respuesta no es JSON");
      }
    })
    .then((data) => {
      console.log("JSON recibido:", data);

      if (data.status === "ok") {
        alert("Producto publicado");
      } else {
        alert("Error: " + data.mensaje);
      }
    })
    .catch((err) => {
      console.error("PETICIÓN FALLIDA:", err);
      alert("Fallo al conectar con el servidor.");
    });
}

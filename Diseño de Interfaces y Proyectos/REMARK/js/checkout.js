document.addEventListener("DOMContentLoaded", () => {
  const producto = JSON.parse(localStorage.getItem("productoSeleccionado"));
  const usuario = localStorage.getItem("usuario");

  // Seguridad: si no hay producto o usuario, redirigir
  if (!producto || !usuario) {
    alert("Error: no hay producto o usuario válido.");
    window.location.href = "productos.html";
    return;
  }

  // Corregir ruta de imagen igual que en productos/búsqueda
  const rutaImagen = producto.imagen
    ? producto.imagen.replace(/^REMARK\//, "")
    : "resources/defecto.jpg";

  // Mostrar resumen en checkout
  document.getElementById("productoResumen").innerHTML = `
    <img src="${rutaImagen}" 
         alt="${producto.nombre}"
         onerror="this.src='resources/defecto.jpg'">

    <h3>${producto.nombre}</h3>

    <p><strong>Precio:</strong> 
      ${parseFloat(producto.precio).toFixed(2)} €
    </p>
  `;

  // Manejo del formulario
  document.getElementById("formCheckout").addEventListener("submit", (e) => {
    e.preventDefault();

    const direccion = document.getElementById("direccion").value.trim();
    const ciudad = document.getElementById("ciudad").value.trim();
    const cp = document.getElementById("cp").value.trim();

    if (!direccion || !ciudad || !cp) {
      alert("Completa todos los campos.");
      return;
    }

    // Guardar pedido
    localStorage.setItem(
      "pedidoActual",
      JSON.stringify({
        producto,
        usuario,
        direccion,
        ciudad,
        cp,
      })
    );

    // Pasar al pago
    window.location.href = "pago.html";
  });
});

document.addEventListener("DOMContentLoaded", () => {
  // Recuperar el producto seleccionado y el usuario logueado desde localStorage
  const producto = JSON.parse(localStorage.getItem("productoSeleccionado"));
  const usuario = localStorage.getItem("usuario");

  // Seguridad: si no hay producto o usuario, mostrar alerta y redirigir
  if (!producto || !usuario) {
    alert("Error: no hay producto o usuario válido.");
    window.location.href = "productos.html";
    return;
  }

  // Corregir ruta de imagen (eliminar prefijo "REMARK/" si existe)
  const rutaImagen = producto.imagen
    ? producto.imagen.replace(/^REMARK\//, "")
    : "resources/defecto.jpg"; // Imagen por defecto si no hay

  // Mostrar resumen del producto en el checkout
  document.getElementById("productoResumen").innerHTML = `
    <img src="${rutaImagen}" 
         alt="${producto.nombre}"
         onerror="this.src='resources/defecto.jpg'">

    <h3>${producto.nombre}</h3>

    <p><strong>Precio:</strong> 
      ${parseFloat(producto.precio).toFixed(2)} €
    </p>
  `;

  // Manejo del formulario de envío
  document.getElementById("formCheckout").addEventListener("submit", (e) => {
    e.preventDefault(); // Evitar recarga de página al enviar

    // Recoger datos del formulario
    const direccion = document.getElementById("direccion").value.trim();
    const ciudad = document.getElementById("ciudad").value.trim();
    const cp = document.getElementById("cp").value.trim();

    // Validación: todos los campos obligatorios
    if (!direccion || !ciudad || !cp) {
      alert("Completa todos los campos.");
      return;
    }

    // Guardar el pedido en localStorage para usar en la página de pago
    localStorage.setItem(
      "pedidoActual",
      JSON.stringify({
        producto, // Producto seleccionado
        usuario, // Usuario que realiza la compra
        direccion, // Dirección de envío
        ciudad, // Ciudad
        cp, // Código postal
      })
    );

    // Redirigir a la pasarela de pago
    window.location.href = "pago.html";
  });
});

document.addEventListener("DOMContentLoaded", async () => {
  // Recuperar pedido actual desde localStorage
  const pedido = JSON.parse(localStorage.getItem("pedidoActual"));

  if (!pedido) {
    // Si no hay pedido, alertar y redirigir a la página de productos
    alert("No hay pedido activo.");
    window.location.href = "productos.html";
    return;
  }

  // Mostrar resumen del pago en la página
  document.getElementById("resumenPago").textContent = `Vas a comprar "${
    pedido.producto.nombre
  }" por ${pedido.producto.precio.toFixed(2)} €`;

  // Asociar el botón "Confirmar" a la función de pago
  document
    .getElementById("btnConfirmar")
    .addEventListener("click", async () => {
      const overlay = document.getElementById("overlay-exito");
      overlay.style.display = "flex"; // Mostrar overlay de éxito

      try {
        // Enviar petición al backend para eliminar producto vendido
        const res = await fetch("backend/delete_product.php", {
          method: "POST",
          headers: { "Content-Type": "application/json; charset=UTF-8" },
          body: JSON.stringify({ nombre: pedido.producto.nombre.trim() }), // Enviar nombre del producto
        });

        const text = await res.text(); // Leer respuesta cruda como texto
        console.log("Respuesta cruda del servidor:", text);

        const data = JSON.parse(text); // Parsear respuesta a JSON
        console.log("Respuesta JSON:", data);
      } catch (err) {
        // Capturar errores de red o parseo JSON
        console.error("Error al eliminar producto:", err);
      }

      // Limpiar pedido y producto seleccionado del localStorage
      localStorage.removeItem("pedidoActual");
      localStorage.removeItem("productoSeleccionado");

      // Redirigir al inicio tras 3 segundos
      setTimeout(() => {
        window.location.href = "index.html";
      }, 3000);
    });
});

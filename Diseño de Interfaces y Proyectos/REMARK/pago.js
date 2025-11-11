document.addEventListener("DOMContentLoaded", async () => {
  const pedido = JSON.parse(localStorage.getItem("pedidoActual"));
  if (!pedido) {
    alert("No hay pedido activo.");
    window.location.href = "productos.html";
    return;
  }

  document.getElementById("resumenPago").textContent = `Vas a comprar "${
    pedido.producto.nombre
  }" por ${pedido.producto.precio.toFixed(2)} €`;

  document
    .getElementById("btnConfirmar")
    .addEventListener("click", async () => {
      const overlay = document.getElementById("overlay-exito");
      overlay.style.display = "flex";
      try {
        const res = await fetch("backend/delete_product.php", {
          method: "POST",
          headers: { "Content-Type": "application/json; charset=UTF-8" },
          body: JSON.stringify({ nombre: pedido.producto.nombre.trim() }),
        });

        const text = await res.text();
        console.log("Respuesta cruda del servidor:", text);

        const data = JSON.parse(text); // <-- solo después de ver la respuesta
        console.log("Respuesta JSON:", data);
      } catch (err) {
        console.error("Error al eliminar producto:", err);
      }

      localStorage.removeItem("pedidoActual");
      localStorage.removeItem("productoSeleccionado");

      setTimeout(() => {
        window.location.href = "index.html";
      }, 3000);
    });
});

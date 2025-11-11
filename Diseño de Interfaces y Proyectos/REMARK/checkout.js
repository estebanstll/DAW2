document.addEventListener("DOMContentLoaded", () => {
  const producto = JSON.parse(localStorage.getItem("productoSeleccionado"));
  const usuario = localStorage.getItem("usuario");

  if (!producto || !usuario) {
    alert("Error: no hay producto o usuario válido.");
    window.location.href = "productos.html";
    return;
  }

  document.getElementById("productoResumen").innerHTML = `
    <img src="${producto.imagen}" alt="${producto.nombre}">
    <h3>${producto.nombre}</h3>
    <p><strong>Precio:</strong> ${producto.precio.toFixed(2)} €</p>
  `;

  document.getElementById("formCheckout").addEventListener("submit", (e) => {
    e.preventDefault();

    const direccion = document.getElementById("direccion").value.trim();
    const ciudad = document.getElementById("ciudad").value.trim();
    const cp = document.getElementById("cp").value.trim();

    if (!direccion || !ciudad || !cp) {
      alert("Completa todos los campos.");
      return;
    }

    localStorage.setItem(
      "pedidoActual",
      JSON.stringify({ producto, usuario, direccion, ciudad, cp })
    );

    window.location.href = "pago.html";
  });
});

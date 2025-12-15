const mostrarDatos = document.getElementById("mostrarDatos");
const array = sessionStorage;

// Recorre todos los elementos del sessionStorage
for (let i = 0; i < array.length; i++) {
  const clave = array.key(i);
  let valor;

  valor = JSON.parse(array.getItem(clave));

  // Validar que sea un objeto libro
  if (
    typeof valor.nombre === "undefined" ||
    typeof valor.autor === "undefined" ||
    typeof valor.paginas === "undefined" ||
    typeof valor.estaPrestado === "undefined"
  ) {
    continue;
  }
  const fichaHTML = `
      <div class="ficha">
        <div class="ficha-header">
         ${valor.nombre}
        </div>
        <div class="ficha-body">
          <p><strong>Nombre Autor:</strong> ${valor.autor}</p>
          <p><strong>Páginas:</strong> ${valor.paginas}</p>
          <p><strong>Prestado:</strong> ${valor.estaPrestado ? "Sí" : "No"}</p>
        </div>
      </div>
    `;

  mostrarDatos.insertAdjacentHTML("beforeend", fichaHTML);
}

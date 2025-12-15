const filtroTipo = document.getElementById("filtroTipo");
const lista = document.getElementById("lista");
const btnFiltrar = document.getElementById("aplicarFiltro");
const btnEliminar = document.getElementById("borrar");

function obtenerTrenes() {
  return JSON.parse(localStorage.getItem("trenes")) || [];
}

function guardarTrenes(arr) {
  localStorage.setItem("trenes", JSON.stringify(arr));
}

function trenes() {
  const tipo = filtroTipo.value;
  const Trenes = obtenerTrenes();

  let filtrados = Trenes.filter((p) => {
    const porTipo = tipo === "todos" || p.tipo === tipo;
    return porTipo;
  });

  if (filtrados.length === 0) {
    lista.innerHTML = "<p>No hay tren que coincidan con el filtro.</p>";
    return;
  }

  lista.innerHTML = filtrados
    .map(
      (p) => `
        <div style="border:1px solid #999;padding:8px;margin:5px;">
          <strong>${p.nombre}</strong><br> 
          Tipo:(${p.tipo})<br>
          Velocidad: ${p.velocidad} <br>
          
        </div>
      `
    )
    .join("");
}

btnFiltrar.addEventListener("click", trenes);

// Función para borrado lógico
btnEliminar.addEventListener("click", (e) => {
  localStorage.setItem("trenes", JSON.stringify([]));
  trenes();
});
trenes();

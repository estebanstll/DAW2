const inputTarea = document.getElementById("Tarea");
const btnGenerar = document.getElementById("generar");
const contenedor = document.getElementById("tablero-container");

const estados = ["normal", "progreso", "completada"];
const colores = {
  normal: "green",
  progreso: "yellow",
  completada: "red",
};

btnGenerar.addEventListener("click", () => {
  if (inputTarea.value.trim() === "") return; // Evitar tareas vacías

  // Crear el div de la tarea
  const tareaDiv = document.createElement("div");
  tareaDiv.textContent = inputTarea.value;
  tareaDiv.dataset.estado = "normal"; // Estado inicial
  tareaDiv.style.backgroundColor = colores.normal;
  tareaDiv.style.padding = "10px";
  tareaDiv.style.margin = "5px 0";
  tareaDiv.style.cursor = "pointer";

  // Cambiar estado al hacer click
  tareaDiv.addEventListener("click", () => {
    const estadoActual = tareaDiv.dataset.estado;
    let indice = estados.indexOf(estadoActual);
    indice = (indice + 1) % estados.length; // pasar al siguiente estado
    const nuevoEstado = estados[indice];
    tareaDiv.dataset.estado = nuevoEstado;
    tareaDiv.style.backgroundColor = colores[nuevoEstado];
  });

  // Eliminar al hacer doble click
  tareaDiv.addEventListener("dblclick", () => {
    contenedor.removeChild(tareaDiv);
  });

  contenedor.appendChild(tareaDiv);

  // Limpiar input
  inputTarea.value = "";
});

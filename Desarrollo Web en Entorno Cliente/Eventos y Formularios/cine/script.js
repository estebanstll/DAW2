// Seleccionamos los elementos del DOM
const container = document.getElementById("asientos-container"); // contenedor de los asientos
const btnGenerar = document.getElementById("generar"); // botón para generar los asientos
const inputFilas = document.getElementById("filas"); // input para número de filas
const inputColumnas = document.getElementById("columnas"); // input para número de columnas

// Función principal para generar los asientos
function generarAsientos() {
  // Leemos los valores de filas y columnas del formulario y los convertimos a números
  const filas = parseInt(inputFilas.value);
  const columnas = parseInt(inputColumnas.value);

  // Ajustamos el grid CSS para que tenga tantas columnas como indicó el usuario
  container.style.gridTemplateColumns = `repeat(${columnas}, 50px)`; // cada asiento mide 50px

  // Limpiamos el contenedor antes de generar nuevos asientos
  container.innerHTML = "";

  // Creamos un array 2D para guardar el estado de cada asiento
  const asientos = [];

  // Bucle para crear las filas
  for (let i = 0; i < filas; i++) {
    asientos[i] = []; // inicializamos la fila
    // Bucle para crear las columnas de cada fila
    for (let j = 0; j < columnas; j++) {
      const asiento = document.createElement("div"); // creamos el div para el asiento
      asiento.classList.add("asiento"); // añadimos la clase CSS "asiento"
      asiento.textContent = `${i + 1}-${j + 1}`; // opcional: mostramos el número de asiento
      asiento.dataset.fila = i; // guardamos la fila en un atributo data
      asiento.dataset.columna = j; // guardamos la columna en un atributo data

      // Estado inicial: libre
      asientos[i][j] = "libre";

      // Evento click: cambia el estado del asiento
      asiento.addEventListener("click", () => {
        if (asientos[i][j] === "libre") {
          // si estaba libre
          asientos[i][j] = "ocupado"; // ahora está ocupado
          asiento.classList.add("ocupado"); // cambiamos la apariencia visual
        } else {
          // si estaba ocupado
          asientos[i][j] = "libre"; // volvemos a libre
          asiento.classList.remove("ocupado"); // revertimos la apariencia
        }

        // Guardamos el estado actualizado en localStorage para que persista
        localStorage.setItem("asientos", JSON.stringify(asientos));
      });

      // Añadimos el asiento al contenedor
      container.appendChild(asiento);
    }
  }

  // Restaurar datos guardados en localStorage si existen
  const asientosGuardados = JSON.parse(localStorage.getItem("asientos"));
  if (asientosGuardados) {
    for (let i = 0; i < filas; i++) {
      for (let j = 0; j < columnas; j++) {
        // Verificamos que haya un asiento guardado y que esté ocupado
        if (asientosGuardados[i] && asientosGuardados[i][j] === "ocupado") {
          asientos[i][j] = "ocupado"; // actualizamos el estado en nuestro array
          const asientoDiv = container.children[i * columnas + j]; // obtenemos el div correspondiente
          asientoDiv.classList.add("ocupado"); // cambiamos la apariencia visual
        }
      }
    }
  }
}

// Asignamos los eventos
btnGenerar.addEventListener("click", generarAsientos); // Generar asientos al hacer click en el botón
window.addEventListener("load", generarAsientos); // Generar asientos automáticamente al cargar la página

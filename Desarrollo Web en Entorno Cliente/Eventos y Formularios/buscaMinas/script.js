const tableroContainer = document.getElementById("tablero-container");
const btnGenerar = document.getElementById("generar");
const inputFilas = document.getElementById("filas");
const inputColumnas = document.getElementById("columnas");
const inputBombas = document.getElementById("bombas");

let tablero = [];
let filas, columnas, numBombas;

// Función para generar tablero
function generarTablero() {
  filas = parseInt(inputFilas.value);
  columnas = parseInt(inputColumnas.value);
  numBombas = parseInt(inputBombas.value);

  tableroContainer.style.gridTemplateColumns = `repeat(${columnas}, 40px)`;
  tableroContainer.innerHTML = "";
  tablero = [];

  // Inicializar tablero
  for (let i = 0; i < filas; i++) {
    tablero[i] = [];
    for (let j = 0; j < columnas; j++) {
      const celda = document.createElement("div");
      celda.classList.add("celda");
      celda.dataset.fila = i;
      celda.dataset.columna = j;
      tablero[i][j] = {
        bomba: false,
        revelada: false,
        bandera: false,
        elemento: celda,
        minasAlrededor: 0,
      };

      celda.addEventListener("click", () => revelarCelda(i, j));
      celda.addEventListener("contextmenu", (e) => {
        e.preventDefault();
        toggleBandera(i, j);
      });

      tableroContainer.appendChild(celda);
    }
  }

  colocarBombas();
  calcularMinasAlrededor();
}

// Colocar bombas aleatoriamente
function colocarBombas() {
  let colocadas = 0;
  while (colocadas < numBombas) {
    const i = Math.floor(Math.random() * filas);
    const j = Math.floor(Math.random() * columnas);
    if (!tablero[i][j].bomba) {
      tablero[i][j].bomba = true;
      colocadas++;
    }
  }
}

// Contar minas alrededor
function calcularMinasAlrededor() {
  for (let i = 0; i < filas; i++) {
    for (let j = 0; j < columnas; j++) {
      if (tablero[i][j].bomba) continue;
      let contador = 0;
      for (let x = -1; x <= 1; x++) {
        for (let y = -1; y <= 1; y++) {
          const ni = i + x;
          const nj = j + y;
          if (ni >= 0 && ni < filas && nj >= 0 && nj < columnas) {
            if (tablero[ni][nj].bomba) contador++;
          }
        }
      }
      tablero[i][j].minasAlrededor = contador;
    }
  }
}

// Revelar celda
function revelarCelda(i, j) {
  const celdaObj = tablero[i][j];
  if (celdaObj.revelada || celdaObj.bandera) return;

  celdaObj.revelada = true;
  celdaObj.elemento.classList.add("revelada");

  if (celdaObj.bomba) {
    celdaObj.elemento.classList.add("bomba");
    alert("¡Bomba! Juego Terminado");
    revelarTodasBombas();
    return;
  }

  if (celdaObj.minasAlrededor > 0) {
    celdaObj.elemento.textContent = celdaObj.minasAlrededor;
  } else {
    // Revelar celdas vecinas si no hay minas alrededor
    for (let x = -1; x <= 1; x++) {
      for (let y = -1; y <= 1; y++) {
        const ni = i + x;
        const nj = j + y;
        if (ni >= 0 && ni < filas && nj >= 0 && nj < columnas) {
          revelarCelda(ni, nj);
        }
      }
    }
  }
}

// Marcar o desmarcar bandera
function toggleBandera(i, j) {
  const celdaObj = tablero[i][j];
  if (celdaObj.revelada) return;

  celdaObj.bandera = !celdaObj.bandera;
  celdaObj.elemento.classList.toggle("bandera");
}

// Revelar todas las bombas al perder
function revelarTodasBombas() {
  for (let i = 0; i < filas; i++) {
    for (let j = 0; j < columnas; j++) {
      if (tablero[i][j].bomba) {
        tablero[i][j].elemento.classList.add("bomba", "revelada");
      }
    }
  }
}

// Guardar intentos/puntuación en localStorage
function guardarPuntuacion(intentos) {
  let puntuaciones = JSON.parse(localStorage.getItem("buscaminas")) || [];
  puntuaciones.push({ filas, columnas, bombas: numBombas, intentos });
  localStorage.setItem("buscaminas", JSON.stringify(puntuaciones));
}

btnGenerar.addEventListener("click", generarTablero);
window.addEventListener("load", generarTablero);

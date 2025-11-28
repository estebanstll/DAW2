// Referencias del DOM
const tableroContainer = document.getElementById("tablero-container");
const btnGenerar = document.getElementById("generar");
const btnReiniciar = document.getElementById("reiniciar");
const inputFilas = document.getElementById("filas");
const inputColumnas = document.getElementById("columnas");
const inputBombas = document.getElementById("bombas");
const banderasRestantesEl = document.getElementById("banderas-restantes");
const tiempoEl = document.getElementById("tiempo");
const mensajeEl = document.getElementById("mensaje");
const verRankingBtn = document.getElementById("ver-ranking");
const rankingDiv = document.getElementById("ranking");
const modal = document.getElementById("modal-nombre");
const inputNombre = document.getElementById("input-nombre");
const guardarNombreBtn = document.getElementById("guardar-nombre");
const cancelarNombreBtn = document.getElementById("cancelar-nombre");

// Variables de Estado
let filas = 10;
let columnas = 10;
let numBombas = 15;
let tablero = [];
let totalCeldas = 0;
let reveladasCount = 0;
let banderasCount = 0;
let gameOver = false;
let timerInterval = null;
let startTime = null;
let firstClick = true;

// --- AUDIO CONTEXT (Corregido para evitar errores de bloqueo) ---
const AudioCtx = window.AudioContext || window.webkitAudioContext;
let audioCtx = null; // Se inicia solo tras el primer click

function initAudio() {
  if (!audioCtx && AudioCtx) {
    audioCtx = new AudioCtx();
  }
  if (audioCtx && audioCtx.state === "suspended") {
    audioCtx.resume();
  }
}

function playSound(type) {
  if (!audioCtx) return;
  try {
    const now = audioCtx.currentTime;
    const osc = audioCtx.createOscillator();
    const gain = audioCtx.createGain();

    osc.connect(gain);
    gain.connect(audioCtx.destination);

    if (type === "click") {
      osc.type = "sine";
      osc.frequency.setValueAtTime(600, now);
      osc.frequency.exponentialRampToValueAtTime(300, now + 0.1);
      gain.gain.setValueAtTime(0.1, now);
      gain.gain.exponentialRampToValueAtTime(0.01, now + 0.1);
      osc.start(now);
      osc.stop(now + 0.1);
    } else if (type === "flag") {
      osc.type = "triangle";
      osc.frequency.setValueAtTime(400, now);
      gain.gain.setValueAtTime(0.1, now);
      gain.gain.exponentialRampToValueAtTime(0.01, now + 0.15);
      osc.start(now);
      osc.stop(now + 0.15);
    } else if (type === "explode") {
      osc.type = "sawtooth";
      osc.frequency.setValueAtTime(100, now);
      osc.frequency.exponentialRampToValueAtTime(10, now + 0.5);
      gain.gain.setValueAtTime(0.3, now);
      gain.gain.exponentialRampToValueAtTime(0.01, now + 0.5);
      osc.start(now);
      osc.stop(now + 0.5);
    } else if (type === "victory") {
      const notes = [523.25, 659.25, 783.99];
      notes.forEach((freq, i) => {
        const o = audioCtx.createOscillator();
        const g = audioCtx.createGain();
        o.connect(g);
        g.connect(audioCtx.destination);
        o.type = "sine";
        o.frequency.value = freq;
        g.gain.setValueAtTime(0.05, now + i * 0.1);
        g.gain.exponentialRampToValueAtTime(0.001, now + i * 0.1 + 0.5);
        o.start(now + i * 0.1);
        o.stop(now + i * 0.1 + 0.6);
      });
    }
  } catch (e) {
    console.error("Error de audio:", e);
  }
}

// --- LÓGICA DEL JUEGO ---

const idx = (i, j) => i * columnas + j;
const fromIdx = (k) => [Math.floor(k / columnas), k % columnas];

function generarTablero() {
  // 1. FORZAR OCULTAR EL MODAL DE VICTORIA
  if (modal) modal.classList.add("hidden");

  // Validar inputs
  filas = parseInt(inputFilas.value) || 10;
  columnas = parseInt(inputColumnas.value) || 10;

  if (filas < 5) filas = 5;
  if (filas > 30) filas = 30;
  if (columnas < 5) columnas = 5;
  if (columnas > 30) columnas = 30;

  inputFilas.value = filas;
  inputColumnas.value = columnas;

  totalCeldas = filas * columnas;
  numBombas = parseInt(inputBombas.value) || 10;

  if (numBombas >= totalCeldas) numBombas = totalCeldas - 1;
  if (numBombas < 1) numBombas = 1;
  inputBombas.value = numBombas;

  // Resetear variables
  tablero = [];
  reveladasCount = 0;
  banderasCount = 0;
  gameOver = false;
  firstClick = true;
  stopTimer();
  tiempoEl.textContent = "00:00";
  mensajeEl.textContent = "Haz click para empezar";

  // UI Update
  banderasRestantesEl.textContent = numBombas;
  tableroContainer.classList.remove("victoria");
  tableroContainer.style.gridTemplateColumns = `repeat(${columnas}, var(--size-cell))`;
  tableroContainer.innerHTML = "";

  // Crear estructura
  const frag = document.createDocumentFragment();

  for (let i = 0; i < filas; i++) {
    const filaArr = [];
    for (let j = 0; j < columnas; j++) {
      const celda = document.createElement("div");
      celda.className = "celda";
      celda.dataset.i = i;
      celda.dataset.j = j;
      celda.setAttribute("role", "button");
      celda.setAttribute("aria-label", `Celda ${i + 1}-${j + 1}`);

      const dataObj = {
        element: celda,
        isBomb: false,
        isRevealed: false,
        isFlagged: false,
        neighborBombs: 0,
      };
      filaArr.push(dataObj);
      frag.appendChild(celda);
    }
    tablero.push(filaArr);
  }
  tableroContainer.appendChild(frag);
}

function colocarBombas(excludeI, excludeJ) {
  const total = filas * columnas;
  const excludeIdx = idx(excludeI, excludeJ);
  const candidates = [];

  const safeZone = new Set();
  safeZone.add(excludeIdx);
  getNeighbors(excludeI, excludeJ).forEach(([ni, nj]) =>
    safeZone.add(idx(ni, nj))
  );

  for (let k = 0; k < total; k++) {
    if (!safeZone.has(k)) candidates.push(k);
  }

  for (let i = candidates.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [candidates[i], candidates[j]] = [candidates[j], candidates[i]];
  }

  const bombIndices = candidates.slice(0, numBombas);
  bombIndices.forEach((k) => {
    const [bi, bj] = fromIdx(k);
    tablero[bi][bj].isBomb = true;
  });

  for (let i = 0; i < filas; i++) {
    for (let j = 0; j < columnas; j++) {
      if (!tablero[i][j].isBomb) {
        let count = 0;
        getNeighbors(i, j).forEach(([ni, nj]) => {
          if (tablero[ni][nj].isBomb) count++;
        });
        tablero[i][j].neighborBombs = count;
      }
    }
  }
}

function getNeighbors(i, j) {
  const neighbors = [];
  for (let di = -1; di <= 1; di++) {
    for (let dj = -1; dj <= 1; dj++) {
      if (di === 0 && dj === 0) continue;
      const ni = i + di;
      const nj = j + dj;
      if (ni >= 0 && ni < filas && nj >= 0 && nj < columnas) {
        neighbors.push([ni, nj]);
      }
    }
  }
  return neighbors;
}

// --- INTERACCIÓN ---

function handleCellClick(i, j) {
  if (gameOver) return;
  initAudio(); // Iniciar audio en interacción de usuario

  const cell = tablero[i][j];
  if (cell.isFlagged || cell.isRevealed) return;

  if (firstClick) {
    colocarBombas(i, j);
    firstClick = false;
    startTimer();
  }

  playSound("click");

  if (cell.isBomb) {
    triggerGameOver(false, cell);
    return;
  }

  revelarCelda(i, j);

  if (reveladasCount === totalCeldas - numBombas) {
    triggerGameOver(true);
  }
}

function revelarCelda(i, j) {
  const queue = [[i, j]];

  while (queue.length > 0) {
    const [currI, currJ] = queue.shift();
    const current = tablero[currI][currJ];

    if (current.isRevealed || current.isFlagged) continue;

    current.isRevealed = true;
    current.element.classList.add("revelada");
    reveladasCount++;

    if (current.neighborBombs > 0) {
      current.element.textContent = current.neighborBombs;
      current.element.dataset.num = current.neighborBombs;
    } else {
      getNeighbors(currI, currJ).forEach(([ni, nj]) => {
        if (!tablero[ni][nj].isRevealed) {
          queue.push([ni, nj]);
        }
      });
    }
  }
}

function handleRightClick(e, i, j) {
  e.preventDefault();
  if (gameOver) return;
  initAudio();

  const cell = tablero[i][j];
  if (cell.isRevealed) return;

  if (!cell.isFlagged) {
    if (banderasCount < numBombas) {
      cell.isFlagged = true;
      cell.element.classList.add("bandera");
      banderasCount++;
      playSound("flag");
    }
  } else {
    cell.isFlagged = false;
    cell.element.classList.remove("bandera");
    banderasCount--;
    playSound("flag");
  }

  banderasRestantesEl.textContent = numBombas - banderasCount;
}

// --- GAME OVER / WIN ---

function triggerGameOver(ganado, clickedCell = null) {
  gameOver = true;
  stopTimer();

  if (!ganado) {
    playSound("explode");
    mensajeEl.textContent = "💥 ¡Bomba! Has perdido.";
    if (clickedCell) clickedCell.element.style.backgroundColor = "#ef4444";

    tablero.forEach((fila) =>
      fila.forEach((c) => {
        if (c.isBomb) {
          c.element.classList.add("revelada", "bomba");
          c.element.textContent = "💣";
        }
      })
    );
  } else {
    playSound("victory");
    mensajeEl.textContent = "🏆 ¡Enhorabuena! Has ganado.";
    tableroContainer.classList.add("victoria");
    banderasRestantesEl.textContent = "0";
    setTimeout(() => abrirModalGuardar(), 600);
  }
}

// --- TIMER ---

function startTimer() {
  stopTimer();
  startTime = Date.now();
  timerInterval = setInterval(() => {
    const delta = Math.floor((Date.now() - startTime) / 1000);
    const m = String(Math.floor(delta / 60)).padStart(2, "0");
    const s = String(delta % 60).padStart(2, "0");
    tiempoEl.textContent = `${m}:${s}`;
  }, 1000);
}

function stopTimer() {
  if (timerInterval) {
    clearInterval(timerInterval);
    timerInterval = null;
  }
}

// --- MODAL & STORAGE ---

function abrirModalGuardar() {
  modal.classList.remove("hidden");
  inputNombre.value = "";
  inputNombre.focus();
}

// Listeners de botones del modal
if (guardarNombreBtn) {
  guardarNombreBtn.onclick = () => {
    const nombre = inputNombre.value.trim() || "Anónimo";
    guardarScore(nombre, tiempoEl.textContent);
    modal.classList.add("hidden");
    mostrarRanking();
  };
}

if (cancelarNombreBtn) {
  cancelarNombreBtn.onclick = () => {
    modal.classList.add("hidden");
  };
}

function guardarScore(nombre, tiempoStr) {
  try {
    const scores = JSON.parse(
      localStorage.getItem("buscaminas_scores") || "[]"
    );
    const [m, s] = tiempoStr.split(":").map(Number);
    const totalSeconds = m * 60 + s;

    const nuevoScore = {
      nombre,
      tiempo: tiempoStr,
      seconds: totalSeconds,
      fecha: new Date().toLocaleDateString(),
      config: `${filas}x${columnas} (${numBombas}💣)`,
    };

    scores.push(nuevoScore);
    scores.sort((a, b) => a.seconds - b.seconds);
    localStorage.setItem(
      "buscaminas_scores",
      JSON.stringify(scores.slice(0, 50))
    );
  } catch (e) {
    console.error("Error guardando score", e);
  }
}

function mostrarRanking() {
  try {
    const scores = JSON.parse(
      localStorage.getItem("buscaminas_scores") || "[]"
    );
    const top5 = scores.slice(0, 5);

    if (top5.length === 0) {
      rankingDiv.innerHTML = "<p>No hay partidas registradas.</p>";
    } else {
      rankingDiv.innerHTML =
        "<ol>" +
        top5
          .map(
            (s) =>
              `<li><strong>${s.tiempo}</strong> - ${s.nombre} <small>(${s.config})</small></li>`
          )
          .join("") +
        "</ol>";
    }
    rankingDiv.classList.remove("hidden");
  } catch (e) {
    console.error("Error ranking", e);
  }
}

if (verRankingBtn) {
  verRankingBtn.onclick = () => {
    if (rankingDiv.classList.contains("hidden")) {
      mostrarRanking();
    } else {
      rankingDiv.classList.add("hidden");
    }
  };
}

// --- INITIALIZATION ---

tableroContainer.addEventListener("click", (e) => {
  const celda = e.target.closest(".celda");
  if (celda) {
    handleCellClick(parseInt(celda.dataset.i), parseInt(celda.dataset.j));
  }
});

tableroContainer.addEventListener("contextmenu", (e) => {
  const celda = e.target.closest(".celda");
  if (celda) {
    handleRightClick(e, parseInt(celda.dataset.i), parseInt(celda.dataset.j));
  }
});

btnGenerar.addEventListener("click", generarTablero);
btnReiniciar.addEventListener("click", () => {
  stopTimer();
  generarTablero();
});

// Arrancar
window.onload = function () {
  generarTablero();
  // Forzar cierre modal al inicio por si acaso
  if (modal) modal.classList.add("hidden");
};

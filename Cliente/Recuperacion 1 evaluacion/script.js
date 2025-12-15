const form = document.getElementById("configForm");
const rowsInput = document.getElementById("rows");
const colsInput = document.getElementById("cols");
const speedInput = document.getElementById("speed");
const trapsInput = document.getElementById("traps");
const loadBtn = document.getElementById("loadConfig");

const panel = document.getElementById("panel");
const livesEl = document.getElementById("lives");
const capturesEl = document.getElementById("captures");
const timeEl = document.getElementById("time");
const gridEl = document.getElementById("grid");
const dialog = document.getElementById("resultDialog");
const resultText = document.getElementById("resultText");
const playAgainBtn = document.getElementById("playAgain");

let rows, cols, speed, trapCount;
let cells = [];
let traps = new Set();
let hunter = -1;
let lives = 3;
let captures = 0;
let moveInterval = null;
let gameSeconds = 0;
let gameTimer = null;

// util
const idx = (r, c) => r * cols + c;

function saveFormToLocalStorage() {
  const cfg = { rows, cols, speed, trapCount };
  localStorage.setItem("hg_config", JSON.stringify(cfg));
}

function loadFormFromLocalStorage() {
  const raw = localStorage.getItem("hg_config");
  if (!raw) return false;
  try {
    const cfg = JSON.parse(raw);
    rowsInput.value = cfg.rows;
    colsInput.value = cfg.cols;
    speedInput.value = cfg.speed;
    trapsInput.value = cfg.trapCount;
    return true;
  } catch (e) {
    return false;
  }
}

loadBtn.addEventListener("click", () => {
  if (loadFormFromLocalStorage()) alert("Configuración cargada");
  else alert("No hay configuración guardada");
});

form.addEventListener("submit", (e) => {
  e.preventDefault();
  // read and validate
  rows = parseInt(rowsInput.value, 10);
  cols = parseInt(colsInput.value, 10);
  speed = parseInt(speedInput.value, 10);
  trapCount = parseInt(trapsInput.value, 10);

  if (isNaN(rows) || isNaN(cols) || isNaN(speed) || isNaN(trapCount))
    return alert("Rellena todos los campos");
  if (rows < 3 || rows > 10 || cols < 3 || cols > 10)
    return alert("Filas/columnas deben estar entre 3 y 10");
  if (speed < 200 || speed > 800) return alert("Velocidad entre 200 y 800 ms");
  if (trapCount < 1 || trapCount > Math.floor((rows * cols) / 3))
    return alert("Número de trampas inválido");

  // persist only form configuration
  saveFormToLocalStorage();
  startGame();
});

function startGame() {
  clearGame();
  cells = Array(rows * cols)
    .fill(null)
    .map((_, i) => createCell(i));
  renderGrid();
  placeTraps();
  placeHunter();
  lives = 3;
  captures = 0;
  gameSeconds = 0;
  updatePanel();
  panel.classList.remove("hidden");
  gameTimer = setInterval(() => {
    gameSeconds += 1;
    timeEl.textContent = gameSeconds;
  }, 1000);
  moveInterval = setInterval(() => moveHunter(), speed);
}

function clearGame() {
  clearInterval(moveInterval);
  moveInterval = null;
  clearInterval(gameTimer);
  gameTimer = null;
  traps.clear();
  hunter = -1;
  cells = [];
  gridEl.innerHTML = "";
}

function createCell(i) {
  const el = document.createElement("div");
  el.className = "cell";
  el.dataset.index = i;
  el.addEventListener("click", onCellClick);
  return el;
}

function renderGrid() {
  gridEl.innerHTML = "";
  gridEl.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
  cells.forEach((c) => gridEl.appendChild(c));
}

function randomEmptyCell() {
  const available = [...Array(rows * cols).keys()].filter(
    (i) => !traps.has(i) && i !== hunter
  );
  return available[Math.floor(Math.random() * available.length)];
}

function placeTraps() {
  traps.clear();
  const total = rows * cols;
  while (traps.size < trapCount) {
    const attempt = Math.floor(Math.random() * total);
    if (attempt === hunter) continue;
    traps.add(attempt);
  }
  // hidden by design
}

function placeHunter() {
  const total = rows * cols;
  let pos = Math.floor(Math.random() * total);
  let attempts = 0;
  while (traps.has(pos) && attempts < total) {
    pos = (pos + 1) % total;
    attempts++;
  }
  hunter = pos;
}

function moveHunter() {
  const r = Math.floor(hunter / cols),
    c = hunter % cols;
  const candidates = [];
  if (r > 0) candidates.push(idx(r - 1, c));
  if (r < rows - 1) candidates.push(idx(r + 1, c));
  if (c > 0) candidates.push(idx(r, c - 1));
  if (c < cols - 1) candidates.push(idx(r, c + 1));
  const valid = candidates.filter((i) => i !== hunter && !traps.has(i));
  if (valid.length === 0) return;
  const next = valid[Math.floor(Math.random() * valid.length)];
  hunter = next;
}

function revealCell(i) {
  const el = cells[i];
  el.classList.add("revealed");
  if (traps.has(i)) {
    const mark = document.createElement("span");
    mark.className = "trap-x";
    mark.textContent = "❌";
    el.textContent = "";
    el.appendChild(mark);
  }
}

function onCellClick(e) {
  const i = Number(e.currentTarget.dataset.index);
  if (i === hunter) {
    // capture
    captures += 1;
    capturesEl.textContent = captures;
    const cell = cells[i];
    cell.classList.add("hunter");
    setTimeout(() => cell.classList.remove("hunter"), 250);

    // increase speed (reduce interval by 5% but not below 100ms)
    clearInterval(moveInterval);
    speed = Math.max(100, Math.floor(speed * 0.95));
    moveInterval = setInterval(() => moveHunter(), speed);

    // regenerate traps (avoid hunter)
    placeTraps();

    checkWinOrContinue();
    return;
  }

  if (traps.has(i)) {
    // hit trap
    lives -= 1;
    livesEl.textContent = lives;
    revealCell(i);
    if (lives <= 0) return endGame(false);
    return;
  }

  // click empty cell: reveal briefly
  const el = cells[i];
  el.classList.add("revealed");
  setTimeout(() => el.classList.remove("revealed"), 400);
}

function checkWinOrContinue() {
  if (captures >= 10) {
    endGame(true);
  }
}

function endGame(won) {
  clearInterval(moveInterval);
  clearInterval(gameTimer);
  resultText.textContent = won ? "¡Has ganado!" : "Has perdido";
  dialog.showModal();
  playAgainBtn.focus();
}

playAgainBtn.addEventListener("click", () => {
  dialog.close();
  startGame();
});

function updatePanel() {
  livesEl.textContent = lives;
  capturesEl.textContent = captures;
  timeEl.textContent = gameSeconds;
}

// small UI updater
setInterval(() => {
  updatePanel();
}, 250);

// load form on open
(function () {
  loadFormFromLocalStorage();
})();

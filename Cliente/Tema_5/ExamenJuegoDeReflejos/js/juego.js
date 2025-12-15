const contenedor = document.getElementById("contenedor");
const punTxt = document.getElementById("pun");

let maxGlobos;
let numGlobos;
let intervalID;
let juegoActivo = false;

const colores = {
  verde: "#00AA00",
  rojo: "#AA0000",
  azul: "#0000AA",
  amarillo: "#AAAA00",
};

const POS = { minX: 0, minY: 0 };
let globos = [];
let puntuacion = 0;
let tiempoInicio;
let juegoTerminado = false;

function randomInt(min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}
function getDayOfMonth() {
  return new Date().getDate();
}

function crearGlobos(n) {
  contenedor.innerHTML = "";
  globos = [];
  for (let i = 0; i < n; i++) {
    const g = document.createElement("div");
    g.classList.add("globo");
    let tipo;
    if (i === 0) {
      tipo = "amarillo";
    } else {
      const r = Math.random();
      if (r < 0.4) tipo = "verde";
      else if (r < 0.6) tipo = "rojo";
      else if (r < 0.8) tipo = "azul";
      else tipo = "verde";
    }
    g.dataset.tipo = tipo;
    g.style.backgroundColor = colores[tipo];
    const Width = contenedor.clientWidth - 50;
    const h = contenedor.clientHeight - 50;
    g.style.left = randomInt(POS.minX, Width) + "px";
    g.style.top = randomInt(POS.minY, h) + "px";
    g.addEventListener("click", () => onClickGlobo(g));
    contenedor.appendChild(g);
    globos.push(g);
  }
}

function onClickGlobo(g) {
  const tipo = g.dataset.tipo;
  switch (tipo) {
    case "verde":
      puntuacion += 1;
      break;
    case "rojo":
      puntuacion -= 1;
      break;
    case "azul":
      congelarJuego();
      break;
    case "amarillo":
      if (!g.dataset.duplicado) {
        puntuacion *= 2;
        g.dataset.duplicado = true;
      }
      break;
  }

  contenedor.removeChild(g);
  const idx = globos.indexOf(g);
  if (idx !== -1) globos.splice(idx, 1);

  if (!globos.some((el) => el.dataset.tipo === "verde")) {
    terminarJuego();
  }
}
function moverGlobos() {
  for (const g of globos) {
    const curX = parseFloat(g.style.left);
    const curY = parseFloat(g.style.top);
    const deltaX = randomInt(10, 50) * (Math.random() < 0.5 ? -1 : 1);
    const deltaY = randomInt(10, 50) * (Math.random() < 0.5 ? -1 : 1);

    let nx = curX + deltaX;
    let ny = curY + deltaY;

    const maxX = contenedor.clientWidth - 50;
    const maxY = contenedor.clientHeight - 50;

    if (nx < POS.minX) nx = POS.minX;
    if (ny < POS.minY) ny = POS.minY;
    if (nx > maxX) nx = maxX;
    if (ny > maxY) ny = maxY;

    g.style.left = nx + "px";
    g.style.top = ny + "px";
  }
}

function congelarJuego() {
  clearInterval(intervalID);
  setTimeout(() => {
    intervalID = setInterval(moverGlobos, 1000);
  }, 2000);
}

function terminarJuego() {
  juegoTerminado = true;
  clearInterval(intervalID);

  const tiempoSeg = Math.round((Date.now() - tiempoInicio) / 1000);
  const punta = puntuacion;

  const partidas = JSON.parse(localStorage.getItem("partidas") || "[]");
  partidas.push({ puntuacion: punta, tiempo: tiempoSeg, fecha: new Date() });
  localStorage.setItem("partidas", JSON.stringify(partidas));
  punTxt.textContent = "Puntuacion: " + punta;
  alert(`Puntuación: ${punta}\nTiempo transcurrido: ${tiempoSeg} s`);
  window.location("index.html");
}

function iniciarJuego() {
  if (juegoActivo) return;

  numGlobos = parseInt(
    prompt(`Introduce el número de globos (máx. ${maxGlobos})`),
    10
  );
  if (!numGlobos || numGlobos > maxGlobos) {
    alert("Número inválido");
    return;
  }
  puntuacion = 0;
  juegoActivo = true;
  juegoTerminado = false;

  crearGlobos(numGlobos);

  intervalID = setInterval(moverGlobos, 1000);
  tiempoInicio = Date.now();
}

maxGlobos = Math.max(15, getDayOfMonth());
iniciarJuego();

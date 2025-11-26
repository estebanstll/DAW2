const juego = document.getElementById("contenedor");
const pun = document.getElementById("pun");

let contador = 0;
let vidas = 7;
let circulosActivos = [];

if (!localStorage.getItem("maxPunt")) {
  localStorage.setItem("maxPunt", contador);
}

// Tamaño del contenedor
let ancho = juego.offsetWidth;
let alto = juego.offsetHeight;

// Funciones para generar posiciones aleatorias
function generadorPosicionX() {
  return Math.floor(Math.random() * (ancho - 50));
}

function crearCirculo() {
  const cir = document.createElement("button");
  cir.classList.add("circulo");

  cir.style.left = generadorPosicionX() + "px";
  cir.style.top = "0px";

  juego.appendChild(cir);

  // Añadimos el círculo al array
  circulosActivos.push(cir);

  // CLICK EN EL CÍRCULO → SUMA PUNTOS Y SE ELIMINA
  cir.addEventListener("click", () => {
    contador++;
    pun.textContent = "puntuación: " + contador;
    eliminarCirculo(cir);
  });

  moverCirculo(cir);
}

function moverCirculo(cir) {
  let pos = 0;

  const intervalo = setInterval(() => {
    pos += 3; // velocidad de caída
    cir.style.top = pos + "px";

    if (pos >= alto - 50) {
      clearInterval(intervalo);
      eliminarCirculo(cir);
      perderVida();
    }
  }, 30);
}

function eliminarCirculo(cir) {
  cir.remove();
  circulosActivos = circulosActivos.filter((c) => c !== cir);
}

function perderVida() {
  vidas--;
  if (vidas < 0) {
    alert("fin del juego, puntuacion: " + contador);
    window.location.href = "index.html";
  }
}

// Crear un círculo cada segundo
setInterval(crearCirculo, 1000);

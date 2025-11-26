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

function generadorPosicionX() {
  return Math.floor(Math.random() * (ancho - 50));
}

function crearCirculo() {
  const cir = document.createElement("button");
  cir.classList.add("circulo");

  cir.style.left = generadorPosicionX() + "px";
  cir.style.top = "0px";

  cir.eliminado = false; // 👈 bandera

  juego.appendChild(cir);
  circulosActivos.push(cir);

  // CLICK → suma puntos y elimina el círculo sin perder vida
  cir.addEventListener("click", () => {
    cir.eliminado = true; // 👈 marcar que fue eliminado por click
    clearInterval(cir.intervalo); // detener caída
    contador++;
    pun.textContent = "puntuación: " + contador;
    eliminarCirculo(cir);
  });

  moverCirculo(cir);
}

function moverCirculo(cir) {
  let pos = 0;

  const intervalo = setInterval(() => {
    // Si ya está eliminado, no seguir procesando
    if (cir.eliminado) {
      clearInterval(intervalo);
      return;
    }

    pos += 3;
    cir.style.top = pos + "px";

    if (pos >= alto - 50) {
      clearInterval(intervalo);

      if (!cir.eliminado) {
        // 👈 ❗ SOLO QUITA VIDA si NO fue clicado
        perderVida();
      }

      eliminarCirculo(cir);
    }
  }, 30);

  cir.intervalo = intervalo;
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

setInterval(crearCirculo, 1000);

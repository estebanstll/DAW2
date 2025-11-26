const btn = document.getElementById("clickMe");
const contenedor = document.getElementById("contenedor");
const out = document.getElementById("output");
const max = document.getElementById("maxPuntuacion");

if (!localStorage.getItem("max")) {
  localStorage.setItem("max", 0);
}

let contador = 0;
let vidas = 5; // 👈 número de vidas inicial
btn.fueClickeado = false; // 👈 bandera

btn.addEventListener("click", () => {
  contador++;
  out.textContent = "¡¡¡¡lo atrapaste un total de " + contador + " veces!!!!";

  btn.fueClickeado = true; // 👈 marcar que sí se hizo click
});

function generadorPosicionX() {
  const ancho = contenedor.clientWidth - btn.offsetWidth;
  return Math.floor(Math.random() * ancho);
}

function generadorPosicionY() {
  const alto = contenedor.clientHeight - btn.offsetHeight;
  return Math.floor(Math.random() * alto);
}

setInterval(() => {
  // 👇 si no fue clicado antes del movimiento → perder vida
  if (!btn.fueClickeado) {
    vidas--;

    if (vidas <= 0) {
      alert("Fin del juego. Puntuación: " + contador);
      window.location.reload();
    }
  }

  // 👇 reseteamos la bandera para el siguiente movimiento
  btn.fueClickeado = false;

  // mueve el botón
  btn.style.left = generadorPosicionX() + "px";
  btn.style.top = generadorPosicionY() + "px";

  // actualizar récord
  let maximo = localStorage.getItem("max");
  if (contador > maximo) {
    localStorage.setItem("max", contador);
  }

  max.textContent =
    "La máxima puntuación registrada es de " + localStorage.getItem("max");
}, 1000);

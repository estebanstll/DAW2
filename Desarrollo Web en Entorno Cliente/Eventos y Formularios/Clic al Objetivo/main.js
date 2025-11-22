const btn = document.getElementById("clickMe");
const contenedor = document.getElementById("contenedor");
const out = document.getElementById("output");
const max = document.getElementById("maxPuntuacion");

if (!localStorage.getItem("max")) {
  localStorage.setItem("max", 0);
}

let contador = 0;

btn.addEventListener("click", (e) => {
  contador++;
  out.textContent = "¡¡¡¡lo atrapaste un total de " + contador + " veces!!!!";
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
  btn.style.left = generadorPosicionX() + "px";
  btn.style.top = generadorPosicionY() + "px";

  let maximo = localStorage.getItem("max");

  if (maximo < contador) {
    localStorage.setItem("max", contador);
  }

  max.textContent =
    "la maxima puntuacion registrada es de " + localStorage.getItem("max");
}, 1000);

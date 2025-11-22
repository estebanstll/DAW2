const divGris = document.getElementById("granDiv");
const palabraAleat = document.getElementById("palabra");
const input = document.getElementById("miInput");
const conta = document.getElementById("contador");

let palabraGenerada = null;
let contador = 0;

let dificultad = 1000;

const palabras = [
  "luminaria",
  "cobalto",
  "vericueto",
  "astrofísico",
  "marea",
  "travesía",
  "orquídea",
  "susurro",
  "cúspide",
  "tempestad",
  "efervescencia",
  "umbría",
  "paradigma",
  "quimera",
  "estuario",
  "bruma",
  "meteorito",
  "sinergia",
  "epifanía",
  "nubarrón",
  "crisálida",
  "elocuencia",
  "aurora",
  "fugacidad",
  "abismo",
];

function almacenarbestScore() {
  const datos = JSON.parse(localStorage.getItem("bestScore"));

  if (contador > datos.puntuacion) {
    const nuevobestScore = {
      nombre: localStorage.getItem("user"),
      puntuacion: contador,
    };

    localStorage.setItem("bestScore", JSON.stringify(nuevobestScore));
  }
}

function aumentarDif() {
  dificultad = dificultad / 1.1;
}

function generadorPalabraAleatoria() {
  let numeroAleat = Math.floor(Math.random() * palabras.length);
  return palabras[numeroAleat];
}

const ancho = divGris.offsetWidth;
const alto = divGris.offsetHeight;

function generadorPosicionX() {
  return Math.floor(Math.random() * ancho);
}

function generadorPosicionY() {
  return Math.floor(Math.random() * alto);
}

function EjexYPalabra() {
  let posicionX = generadorPosicionX();
  palabraGenerada = generadorPalabraAleatoria();

  palabraAleat.style.left = posicionX + "px";
  palabraAleat.textContent = palabraGenerada;
}

EjexYPalabra();

function actualizadorDeY() {
  let posicionY = generadorPosicionY();
  palabraAleat.style.top = posicionY + "px";

  if (posicionY >= divGris.offsetHeight - palabraAleat.offsetHeight) {
    EjexYPalabra();
  }
}

setInterval(() => {
  actualizadorDeY();
}, dificultad);

input.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    let textoIntroducido = input.value;

    if (textoIntroducido === palabraGenerada) {
      EjexYPalabra();
      contador++;
      aumentarDif();
      conta.textContent = "Aciertos: " + contador;
      almacenarbestScore();
    } else {
      EjexYPalabra();
    }
  }
});

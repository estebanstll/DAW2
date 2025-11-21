const divGris = document.getElementById("granDiv");

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

function generadorPalabraAleatoria() {
  let numeroAleat = Math.floor(Math.random * 25);
  return palabras[numeroAleat];
}

function generadorPosicionX() {
  let numeroAleat = Math.floor(Math.random * 25);
  return palabras[numeroAleat];
}

function generadorPosicionY() {
  let numeroAleat = Math.floor(Math.random * 25);
  return palabras[numeroAleat];
}

const ancho = divGris.offsetWidth;
const alto = divGris.offsetHeight;

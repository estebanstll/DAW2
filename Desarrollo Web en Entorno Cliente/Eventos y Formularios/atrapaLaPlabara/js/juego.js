//sacar datos DOM
const divGris = document.getElementById("granDiv");
const palabraAleat = document.getElementById("palabra");
const input = document.getElementById("miInput");
const conta = document.getElementById("contador");

//creacion de variables
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

//comprobar el resultado mas alto y actualizarlo en caso de que sea mejor que el del localStorage
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

//generar posiciones aleatorias para la palabra
function generadorPosicionX() {
  return Math.floor(Math.random() * ancho);
}

function generadorPosicionY() {
  return Math.floor(Math.random() * alto);
}

//actualizador de la posicion x y de la palabra
function EjexYPalabra() {
  let posicionX = generadorPosicionX();
  palabraGenerada = generadorPalabraAleatoria();

  palabraAleat.style.left = posicionX + "px";
  palabraAleat.textContent = palabraGenerada;
}
//se ejecuta por primera vez el eje x y la palabra para poder guardarlas en sus variables correspondientes y asi luego poder acceder a estas
EjexYPalabra();

function actualizadorDeY() {
  let posicionY = generadorPosicionY();
  palabraAleat.style.top = posicionY + "px";

  if (posicionY >= divGris.offsetHeight - palabraAleat.offsetHeight) {
    EjexYPalabra();
  }
}

setInterval(() => {
  //intervalo de actualizacion
  actualizadorDeY();
}, dificultad);

//evento para saber si se adivina o no la palabra
input.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    let textoIntroducido = input.value;
    //si la palabra a sido adivinada cambiara la posicion en el eje X y en el eje Y, ademas cambia la palabra y es un vuelta a empezar con el interval
    if (textoIntroducido === palabraGenerada) {
      EjexYPalabra();
      contador++;
      aumentarDif();
      conta.textContent = "Aciertos: " + contador;
      almacenarbestScore(); //comprobar si has batido el record o no
    } else {
      EjexYPalabra();
    }
  }
});

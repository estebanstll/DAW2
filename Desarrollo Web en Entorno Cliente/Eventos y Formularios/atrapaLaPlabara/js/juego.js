// Obtener elementos del DOM
const divGris = document.getElementById("granDiv");
const input = document.getElementById("miInput");
const conta = document.getElementById("contador");

// Variables
let palabraGenerada = "";
let contador = 0;
let dificultad = 500; // ms por actualización
let intervalo = null;

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

// Crear la palabra dinámicamente
const palabraAleat = document.createElement("div");
palabraAleat.style.position = "absolute";
palabraAleat.style.fontSize = "24px";
palabraAleat.style.color = "white";
divGris.appendChild(palabraAleat);

// Guardar ancho/alto del contenedor
let ancho = divGris.offsetWidth;
let alto = divGris.offsetHeight;

// Generadores aleatorios
function generadorPalabraAleatoria() {
  return palabras[Math.floor(Math.random() * palabras.length)];
}
function generadorPosicionX() {
  return Math.floor(Math.random() * (ancho - 100));
}

// Reiniciar palabra arriba
function resetPalabra() {
  palabraGenerada = generadorPalabraAleatoria();
  palabraAleat.textContent = palabraGenerada;
  palabraAleat.style.left = generadorPosicionX() + "px";
  palabraAleat.style.top = "0px";
}

// Mover palabra hacia abajo
function moverPalabra() {
  let aleat = Math.floor(Math.random() * palabras.length);
  let yActual = parseInt(palabraAleat.style.top);
  let nuevoY = yActual + aleat; // velocidad base de caída

  palabraAleat.style.top = nuevoY + "px";

  // Si toca fondo reiniciar palabra
  if (nuevoY >= alto - 40) {
    resetPalabra();
  }
}

// Intervalo controlado para permitir reiniciarlo
function iniciarMovimiento() {
  if (intervalo) clearInterval(intervalo);
  if (dificultad < 700) {
    intervalo = setInterval(moverPalabra, dificultad);
  }
  intervalo = setInterval(moverPalabra, dificultad);
}

// Almacenar best score
function almacenarbestScore() {
  const datos = JSON.parse(localStorage.getItem("bestScore")) || {
    puntuacion: 0,
  };

  if (contador > datos.puntuacion) {
    const nuevo = {
      nombre: localStorage.getItem("user"),
      puntuacion: contador,
    };
    localStorage.setItem("bestScore", JSON.stringify(nuevo));
  }
}

// Aumentar dificultad (reduce intervalo)
function aumentarDif() {
  dificultad = dificultad / 1.1;
  iniciarMovimiento(); // para aplicar la nueva velocidad
}

// Evento cuando se presiona Enter
input.addEventListener("keydown", function (event) {
  if (event.key === "Enter") {
    let textoIntroducido = input.value;

    if (textoIntroducido === palabraGenerada) {
      contador++;
      conta.textContent = "Aciertos: " + contador;
      aumentarDif();
      almacenarbestScore();
    }

    resetPalabra();
    input.value = ""; // limpiar campo
  }
});

// Inicializar todo
resetPalabra();
iniciarMovimiento();

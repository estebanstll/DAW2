import Libro from "./libro.js";

const btn = document.getElementById("crear");
const nombre = document.getElementById("nombre");
const paginas = document.getElementById("Paginas");
const estaPrestado = document.getElementById("prestado");

btn.addEventListener("click", (e) => {
  e.preventDefault();

  const libro = new Libro(
    nombre.value,
    "Rafa",
    parseInt(paginas.value),
    estaPrestado.checked
  );

  sessionStorage.setItem(libro.nombre, JSON.stringify(libro));
});

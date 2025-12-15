import { Libro } from "./libro.js";

// Navegación
document.getElementById("logo").addEventListener("click", mostrarHome);
document.getElementById("btnHome").addEventListener("click", mostrarHome);
document
  .getElementById("btnConsultar")
  .addEventListener("click", mostrarConsultar);
document.getElementById("btnCrear").addEventListener("click", mostrarCrear);

document.getElementById("formCrear").addEventListener("submit", crearLibro);
// Array global de libros

async function libross() {
  let respuesta = await fetch("http://localhost:3000/libros");
  return await respuesta.json();
}

let libros = [];

async function cargarLibros() {
  libros = await libross();
}

cargarLibros();

// Navegación
function ocultarTodo() {
  document.getElementById("home").classList.add("hidden");
  document.getElementById("consultar").classList.add("hidden");
  document.getElementById("crear").classList.add("hidden");
}

function mostrarHome() {
  ocultarTodo();
  document.getElementById("home").classList.remove("hidden");
}

function mostrarConsultar() {
  ocultarTodo();
  document.getElementById("consultar").classList.remove("hidden");
  pintarLibros();
}

function mostrarCrear() {
  ocultarTodo();
  document.getElementById("crear").classList.remove("hidden");
}

// Crear libro
async function crearLibro(event) {
  event.preventDefault();

  const titulo = document.getElementById("titulo").value;
  const autor = document.getElementById("autor").value;
  const anio = document.getElementById("anio").value;

  let libro = new Libro(titulo, autor, anio);
  let myHeaders = new Headers({
    "Content-Type": "application/json",
  });

  const envio = await fetch("http://localhost:3000/libros", {
    method: "post",
    headers: myHeaders,
    body: JSON.stringify(libro),
  });

  event.target.reset();
  libros.push(libro);
  mostrarConsultar();
}

// Pintar libros
function pintarLibros() {
  const tbody = document.getElementById("tablaLibros");
  tbody.innerHTML = "";

  for (const libro of libros) {
    const fila = document.createElement("tr");
    fila.innerHTML = `
                <td>${libro.titulo}</td>
                <td>${libro.autor}</td>
                <td>${libro.anio}</td>
            `;
    tbody.appendChild(fila);
  }
}

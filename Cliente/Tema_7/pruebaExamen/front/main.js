import { Libro } from "./libro.js";

// Navegación
document.getElementById("logo").addEventListener("click", mostrarHome);
document.getElementById("btnHome").addEventListener("click", mostrarHome);
document
  .getElementById("btnConsultar")
  .addEventListener("click", mostrarConsultar);
document.getElementById("btnCrear").addEventListener("click", mostrarCrear);

// NUEVOS botones
document.getElementById("btnPut").addEventListener("click", mostrarPut);
document.getElementById("btnDelete").addEventListener("click", mostrarDelete);

document.getElementById("formCrear").addEventListener("submit", crearLibro);

// Array global de libros (solo local)
let libros = [];

//metodos de la api

// 1 Get de libros
async function getLibros() {
  try {
    const respuesta = await fetch("http://localhost:3000/libro");
    const datos = await respuesta.json();
    libros = datos;
  } catch (e) {
    console.error(e);
  }
}

// 2 Post
async function postLibro(libro) {
  await fetch("http://localhost:3000/libro", {
    method: "Post",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(libro),
  });
}

// 3 Put

async function putLibro(tituloOriginal, nuevoLibro) {
  const respuesta = await fetch(
    `http://localhost:3000/libros/${tituloOriginal}`,
    {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(nuevoLibro),
    },
  );

  const data = await respuesta.json();

  if (respuesta.ok) {
    console.log("Libro actualizado:", data);
  } else {
    console.error("Error:", data.message);
  }
}

// 4 Delete

async function deleteLibro(id) {
  const respuesta = await fetch(`http://localhost:3000/libro/${id}`, {
    method: "DELETE",
  });

  if (respuesta.status === 204) {
    console.log("Libro borrado");
  } else {
    const error = await respuesta.json();
    console.error("Error:", error.message);
  }
}

// Navegación
function ocultarTodo() {
  document.getElementById("home").classList.add("hidden");
  document.getElementById("consultar").classList.add("hidden");
  document.getElementById("crear").classList.add("hidden");
  document.getElementById("put").classList.add("hidden");
  document.getElementById("delete").classList.add("hidden");
}

function mostrarHome() {
  ocultarTodo();
  document.getElementById("home").classList.remove("hidden");
}

function mostrarConsultar() {
  ocultarTodo();
  document.getElementById("consultar").classList.remove("hidden");
  getLibros();
  pintarLibros();
}

function mostrarCrear() {
  ocultarTodo();
  document.getElementById("crear").classList.remove("hidden");
}

function mostrarPut() {
  ocultarTodo();
  document.getElementById("put").classList.remove("hidden");

  const cont = document.getElementById("putContainer");
  cont.innerHTML = "";

  const inputTituloOriginal = document.createElement("input");
  inputTituloOriginal.id = "putTituloOriginal";
  inputTituloOriginal.placeholder = "Título original del libro";

  const inputTitulo = document.createElement("input");
  inputTitulo.id = "putTitulo";
  inputTitulo.placeholder = "Nuevo título";

  const inputAutor = document.createElement("input");
  inputAutor.id = "putAutor";
  inputAutor.placeholder = "Nuevo autor";

  const inputAnio = document.createElement("input");
  inputAnio.id = "putAnio";
  inputAnio.placeholder = "Nuevo año";

  const btn = document.createElement("button");
  btn.textContent = "Modificar";
  btn.addEventListener("click", async () => {
    const tituloOriginal = inputTituloOriginal.value.trim();
    const titulo = inputTitulo.value.trim();
    const autor = inputAutor.value.trim();
    const anio = inputAnio.value.trim();

    if (!tituloOriginal || !titulo || !autor || !anio) {
      return alert("Rellena todos los campos");
    }

    const libroActualizado = new Libro(titulo, autor, anio);

    await putLibro(tituloOriginal, libroActualizado);

    alert("Libro modificado correctamente");
    mostrarConsultar();
  });

  cont.appendChild(inputTituloOriginal);
  cont.appendChild(document.createElement("br"));
  cont.appendChild(inputTitulo);
  cont.appendChild(document.createElement("br"));
  cont.appendChild(inputAutor);
  cont.appendChild(document.createElement("br"));
  cont.appendChild(inputAnio);
  cont.appendChild(document.createElement("br"));
  cont.appendChild(btn);
}

function mostrarDelete() {
  ocultarTodo();
  document.getElementById("delete").classList.remove("hidden");

  const cont = document.getElementById("deleteContainer");
  cont.innerHTML = "";

  const input = document.createElement("input");
  input.id = "deleteTitulo";
  input.placeholder = "Introduce el id";

  const btn = document.createElement("button");
  btn.textContent = "Eliminar";
  btn.addEventListener("click", () => {
    const id = input.value.trim();

    if (!id) return alert("Introduce un título");

    deleteLibro(id);
  });

  cont.appendChild(input);
  cont.appendChild(document.createElement("br"));
  cont.appendChild(btn);
}

// Crear libro (solo en memoria)
function crearLibro(event) {
  event.preventDefault();

  const titulo = document.getElementById("titulo").value;
  const autor = document.getElementById("autor").value;
  const anio = document.getElementById("anio").value;

  const libro = new Libro(titulo, autor, anio);
  postLibro(libro);
  event.target.reset();
  mostrarConsultar();
}

// Pintar libros
function pintarLibros() {
  const tbody = document.getElementById("tablaLibros");
  tbody.innerHTML = "";

  for (const libro of libros) {
    const fila = document.createElement("tr");
    fila.innerHTML = `
      <td>${libro._id}</td>
      <td>${libro.titulo}</td>
      <td>${libro.autor}</td>
      <td>${libro.anio}</td>
    `;
    tbody.appendChild(fila);
  }
}

import { coche } from "./coche.js";

// Navegación
document.getElementById("logo").addEventListener("click", mostrarHome);
document.getElementById("btnHome").addEventListener("click", mostrarHome);
document
  .getElementById("btnConsultar")
  .addEventListener("click", mostrarConsultar);
document.getElementById("btnCrear").addEventListener("click", mostrarCrear);

document.getElementById("formCrear").addEventListener("submit", crearCoche);
// Array global de coche

async function coches() {
  let respuesta = await fetch("http://localhost:3000/coches");
  return await respuesta.json();
}

async function deleteCoche(marca) {
  let respuesta = await fetch(`http://localhost:3000/coches/${marca}`, {
    method: "DELETE",
  });
  return await respuesta.json();
}

async function updateCoche(marca, nuevoModelo) {
  const respuesta = await fetch(`http://localhost:3000/coches/${marca}`, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ modelo: nuevoModelo }),
  });

  return await respuesta.json();
}

let cochera = [];

async function cargarcoche() {
  cochera = await coches();
}

cargarcoche();

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
  pintarcoche();
}

function mostrarCrear() {
  ocultarTodo();
  document.getElementById("crear").classList.remove("hidden");
}

// Crear coche
async function crearCoche(event) {
  event.preventDefault();

  const marca = document.getElementById("marca").value;
  const modelo = document.getElementById("modelo").value;
  const img = document.getElementById("img").value;

  const nuevo = new coche(marca, modelo, img);

  const respuesta = await fetch("http://localhost:3000/coches", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(nuevo),
  });

  if (!respuesta.ok) {
    alert("Error al crear el coche");
    return;
  }

  const guardado = await respuesta.json();
  cochera.push(guardado);
  event.target.reset();
  mostrarConsultar();
}

// Pintar coche
function pintarcoche() {
  const tbody = document.getElementById("tablacoche");
  tbody.innerHTML = "";

  for (const item of cochera) {
    const fila = document.createElement("tr");
    fila.innerHTML = `
                <td>${item.marca}</td>
                <td>${item.modelo}</td>
                <td>${item.img}</td>
                <td><button class="btnDelete" data-marca="${item.marca}">Eliminar</button><button class="btnEdit" data-marca="${item.marca}">Editar</button></td>
            `;
    tbody.appendChild(fila);
  }
}

const tbody = document.getElementById("tablacoche");

tbody.addEventListener("click", (e) => {
  if (e.target.classList.contains("btnDelete")) {
    const marca = e.target.dataset.marca;

    deleteCoche(marca);

    // quitar del array
    cochera = cochera.filter((c) => c.marca !== marca);

    pintarcoche();
  }

  if (e.target.classList.contains("btnEdit")) {
    const marca = e.target.dataset.marca;
    const nuevoModelo = prompt("Nuevo modelo:");

    if (!nuevoModelo) return;

    updateCoche(marca, nuevoModelo);

    const coche = cochera.find((c) => c.marca === marca);
    if (coche) {
      coche.modelo = nuevoModelo;
    }

    pintarcoche();
  }
});

const url = "http://localhost:3000/animal";
import { animal } from "./animal.js";
let animalActual = null;
let perrera = [];

async function getAnimales() {
  let respuesta = await fetch(url);
  let datos = await respuesta.json();
  return datos;
}

async function updateAnimal(animal, nuevoEstado) {
  const url = `http://localhost:3000/animal/${animal.nombre}`;

  const nuevoAnimal = {
    nombre: animal.nombre,
    estado: nuevoEstado,
    descripcion: animal.descripcion,
    img: animal.img,
  };

  const respuesta = await fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(nuevoAnimal),
  });

  if (!respuesta.ok) {
    throw new Error("Error al actualizar");
  }

  const datos = await respuesta.json();
  return datos;
}

perrera = await getAnimales();

const modal = document.getElementById("modal");
const modalImg = document.getElementById("modalImg");
const modalNombre = document.getElementById("modalNombre");
const modalDescripcion = document.getElementById("modalDescripcion");
const modalEstado = document.getElementById("modalEstado");
const modalClose = document.getElementById("modalClose");
const modalUpdate = document.getElementById("btnUpdate");
const modalDelete = document.getElementById("btnDelete");

export function pintarCards(animales) {
  const contenedor = document.getElementById("cardsContainer");
  contenedor.innerHTML = "";

  for (const animal of animales) {
    const card = document.createElement("article");
    card.classList.add("card");

    const img = document.createElement("img");
    img.src = `resources/img/${animal.img}`;
    img.onerror = () => {
      img.src = "resources/img/defecto.jpg";
    };

    const nombre = document.createElement("h3");
    nombre.textContent = animal.nombre;
    if (animal.estado === "Adoptado") {
      nombre.style.color = "red";
    } else {
      nombre.style.color = "green";
    }

    card.appendChild(img);
    card.appendChild(nombre);
    contenedor.appendChild(card);

    card.addEventListener("click", () => {
      animalActual = animal;
      modalImg.src = img.src;
      modalNombre.textContent = animal.nombre;
      modalDescripcion.textContent = animal.descripcion;
      modalEstado.textContent = `Estado: ${animal.estado}`;
      modal.showModal(); // HTML5 modal
    });
  }
}

modalClose.addEventListener("click", () => {
  modal.close();
});

modal.addEventListener("click", (e) => {
  if (e.target === modal) modal.close();
});

modalUpdate.addEventListener("click", (e) => {
  e.preventDefault();
  let respuesta = prompt("introduce el nuevo estado");
  if (!respuesta) return;

  updateAnimal(animalActual, respuesta);
  window.location.href = "index.html";
});

async function iniciador() {
  await pintarCards(perrera);
}

iniciador();

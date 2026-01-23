const url = "http://localhost:3000/coches";
import { coche } from "./coche.js";
let cocheActual = null;
let garaje = [];

async function getcoche() {
  let respuesta = await fetch(url);
  let datos = await respuesta.json();
  return datos;
}

async function updatecoche(coche, nuevoModelo) {
  const url = `http://localhost:3000/coches/${coche.marca}`;

  const nuevocoche = {
    modelo: nuevoModelo,
    img: coche.img,
  };

  const respuesta = await fetch(url, {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(nuevocoche),
  });

  if (!respuesta.ok) {
    throw new Error("Error al actualizar");
  }

  const datos = await respuesta.json();
  return datos;
}

async function deletecoche(coche) {
  const url = `http://localhost:3000/coches/${coche.marca}`;

  const respuesta = await fetch(url, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
  });

  if (!respuesta.ok) {
    throw new Error("Error al eliminar");
  }

  const datos = await respuesta.json();
  return datos;
}

garaje = await getcoche();

const modal = document.getElementById("modal");
const modalImg = document.getElementById("modalImg");
const modalNombre = document.getElementById("modalNombre");
const modalDescripcion = document.getElementById("modalDescripcion");
const modalEstado = document.getElementById("modalEstado");
const modalClose = document.getElementById("modalClose");
const modalUpdate = document.getElementById("btnUpdate");
const modalDelete = document.getElementById("btnDelete");

export function pintarCards(coches) {
  const contenedor = document.getElementById("cardsContainer");
  contenedor.innerHTML = "";

  for (const coche of coches) {
    const card = document.createElement("article");
    card.classList.add("card");

    const img = document.createElement("img");
    img.src = `resources/img/${coche.img}`;
    img.onerror = () => {
      img.src = "resources/img/defecto.jpg";
    };

    const nombre = document.createElement("h3");
    nombre.textContent = coche.marca;
    nombre.style.color = "blue";

    card.appendChild(img);
    card.appendChild(nombre);
    contenedor.appendChild(card);

    card.addEventListener("click", () => {
      cocheActual = coche;
      modalImg.src = img.src;
      modalNombre.textContent = coche.marca;
      modalDescripcion.textContent = coche.modelo;
      modalEstado.textContent = `Modelo: ${coche.modelo}`;
      modal.showModal();
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
  let respuesta = prompt("introduce el nuevo modelo");
  if (!respuesta) return;

  updatecoche(cocheActual, respuesta);
  window.location.href = "index.html";
});

modalDelete.addEventListener("click", (e) => {
  e.preventDefault();
  if (confirm("¿Estás seguro de que quieres eliminar este coche?")) {
    deletecoche(cocheActual);
    window.location.href = "index.html";
  }
});

async function iniciador() {
  await pintarCards(garaje);
}

iniciador();

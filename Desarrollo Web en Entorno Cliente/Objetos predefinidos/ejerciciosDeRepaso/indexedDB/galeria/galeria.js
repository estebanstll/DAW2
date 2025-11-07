let db;

const inputImagen = document.getElementById("inputImagen");
const btnAgregar = document.getElementById("agregar");
const galeria = document.getElementById("galeria");

// Abrir IndexedDB
const request = indexedDB.open("GaleriaDB", 1);

request.onerror = function () {
  console.error("Error al abrir la base de datos");
};

request.onsuccess = function (event) {
  db = event.target.result;
  mostrarImagenes();
};

request.onupgradeneeded = function (event) {
  db = event.target.result;
  db.createObjectStore("imagenes", { keyPath: "id", autoIncrement: true });
};

// Agregar imagen
btnAgregar.addEventListener("click", () => {
  const archivo = inputImagen.files[0];
  if (!archivo) return;

  const transaction = db.transaction("imagenes", "readwrite");
  const store = transaction.objectStore("imagenes");
  store.add({ blob: archivo });

  transaction.oncomplete = () => {
    inputImagen.value = "";
    mostrarImagenes();
  };
});

// Mostrar todas las imágenes
function mostrarImagenes() {
  galeria.innerHTML = "";
  const transaction = db.transaction("imagenes", "readonly");
  const store = transaction.objectStore("imagenes");
  const request = store.getAll();

  request.onsuccess = function () {
    request.result.forEach((item) => {
      const url = URL.createObjectURL(item.blob);

      const contenedor = document.createElement("div");
      contenedor.style.position = "relative";

      const img = document.createElement("img");
      img.src = url;
      img.style.width = "150px";
      img.style.height = "150px";
      img.style.objectFit = "cover";

      const btnEliminar = document.createElement("button");
      btnEliminar.textContent = "Eliminar";
      btnEliminar.style.position = "absolute";
      btnEliminar.style.top = "5px";
      btnEliminar.style.right = "5px";

      btnEliminar.addEventListener("click", () => eliminarImagen(item.id));

      contenedor.appendChild(img);
      contenedor.appendChild(btnEliminar);
      galeria.appendChild(contenedor);
    });
  };
}

// Eliminar imagen
function eliminarImagen(id) {
  const transaction = db.transaction("imagenes", "readwrite");
  const store = transaction.objectStore("imagenes");
  store.delete(id);

  transaction.oncomplete = mostrarImagenes;
}

let db;

const lista = document.getElementById("lista");
const input = document.getElementById("tareaInput");
const btnAgregar = document.getElementById("agregar");

// Abrir la base de datos
const request = indexedDB.open("TareasDB", 1);

//Manejar errores al abrir
request.onerror = function () {
  console.error("Error al abrir la base de datos");
};

// Si se abre correctamente
request.onsuccess = function (event) {
  db = event.target.result; // Guardar la base de datos en una variable
  mostrarTareas(); // Llamar a función para mostrar las tareas existentes
};

// Se ejecuta la primera vez o al cambiar la versión
request.onupgradeneeded = function (event) {
  db = event.target.result; // Guardar la base de datos
  // Crear un "almacén de objetos" llamado "tareas"
  // Cada objeto tendrá un id único que se autoincrementa
  const store = db.createObjectStore("tareas", {
    keyPath: "id",
    autoIncrement: true,
  });
};

// Agregar tarea
btnAgregar.addEventListener("click", () => {
  const texto = input.value.trim();
  if (!texto) return;

  const transaction = db.transaction("tareas", "readwrite");
  const store = transaction.objectStore("tareas");
  store.add({ texto: texto });

  transaction.oncomplete = () => {
    input.value = "";
    mostrarTareas();
  };
});

// Mostrar todas las tareas
function mostrarTareas() {
  lista.innerHTML = "";
  const transaction = db.transaction("tareas", "readonly");
  const store = transaction.objectStore("tareas");
  const request = store.getAll();

  request.onsuccess = function () {
    request.result.forEach((t) => {
      const li = document.createElement("li");
      li.textContent = t.texto;

      // Botón eliminar
      const btnEliminar = document.createElement("button");
      btnEliminar.textContent = "Eliminar";
      btnEliminar.addEventListener("click", () => eliminarTarea(t.id));

      li.appendChild(btnEliminar);
      lista.appendChild(li);
    });
  };
}

// Eliminar tarea
function eliminarTarea(id) {
  const transaction = db.transaction("tareas", "readwrite");
  const store = transaction.objectStore("tareas");
  store.delete(id);

  transaction.oncomplete = mostrarTareas;
}

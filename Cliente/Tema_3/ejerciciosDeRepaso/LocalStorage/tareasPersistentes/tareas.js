document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("nuevaTarea");
  const btnAgregar = document.getElementById("agregar");
  const lista = document.getElementById("lista");

  // Cargar tareas desde localStorage
  let tareas = JSON.parse(localStorage.getItem("tareas")) || [];

  // Mostrar las tareas guardadas al cargar la página
  renderizarTareas();

  // Evento para agregar una tarea
  btnAgregar.addEventListener("click", () => {
    const texto = input.value.trim();
    if (texto === "") return;

    // Crear objeto tarea
    const tarea = {
      id: Date.now(),
      texto: texto,
      completada: false,
    };

    tareas.push(tarea);
    guardarYMostrar();
    input.value = "";
  });

  // Función para marcar o eliminar una tarea (delegación de eventos)
  lista.addEventListener("click", (e) => {
    const id = e.target.dataset.id;

    if (e.target.classList.contains("eliminar")) {
      tareas = tareas.filter((t) => t.id != id);
      guardarYMostrar();
    }

    if (e.target.classList.contains("texto")) {
      tareas = tareas.map((t) =>
        t.id == id ? { ...t, completada: !t.completada } : t
      );
      guardarYMostrar();
    }
  });

  // Guardar en localStorage y renderizar
  function guardarYMostrar() {
    localStorage.setItem("tareas", JSON.stringify(tareas));
    renderizarTareas();
  }

  // Renderizar tareas en el DOM
  function renderizarTareas() {
    lista.innerHTML = "";

    if (tareas.length === 0) {
      lista.innerHTML = "<li>No hay tareas aún 💤</li>";
      return;
    }

    tareas.forEach((t) => {
      const li = document.createElement("li");
      li.innerHTML = `
        <span class="texto" data-id="${t.id}" style="text-decoration: ${
        t.completada ? "line-through" : "none"
      };">
          ${t.texto}
        </span>
        <button class="eliminar" data-id="${t.id}">❌</button>
      `;
      lista.appendChild(li);
    });
  }
});

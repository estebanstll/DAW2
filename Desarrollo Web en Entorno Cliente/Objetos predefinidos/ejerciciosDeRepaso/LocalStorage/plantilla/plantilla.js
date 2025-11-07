document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("valor");
  const resultado = document.getElementById("resultado");

  const btnAgregar = document.getElementById("agregar");
  const btnMostrar = document.getElementById("mostrar");
  const btnModificar = document.getElementById("modificar");
  const btnEliminar = document.getElementById("eliminar");
  const btnReset = document.getElementById("reset");

  // Inicializar el array si no existe en localStorage
  if (!localStorage.getItem("a")) {
    localStorage.setItem("a", JSON.stringify([]));
  }

  // Función para obtener el array actual
  function obtenerArray() {
    return JSON.parse(localStorage.getItem("a")) || [];
  }

  // Función para guardar el array actualizado
  function guardarArray(arr) {
    localStorage.setItem("a", JSON.stringify(arr));
  }

  // Agregar un elemento al array
  btnAgregar.addEventListener("click", () => {
    const valor = input.value.trim();
    if (valor === "") {
      resultado.textContent = "Debes escribir un valor.";
      return;
    }

    const arr = obtenerArray();
    arr.push(valor);
    guardarArray(arr);
    resultado.textContent = `Elemento "${valor}" agregado.`;
    input.value = "";
  });

  // Mostrar el array
  btnMostrar.addEventListener("click", () => {
    const arr = obtenerArray();
    if (arr.length === 0) {
      resultado.textContent = "El array está vacío.";
    } else {
      resultado.textContent = "Contenido del array: " + arr.join(", ");
    }
  });

  // Modificar el primer elemento
  btnModificar.addEventListener("click", () => {
    const arr = obtenerArray();
    if (arr.length === 0) {
      resultado.textContent = "No hay elementos para modificar.";
      return;
    }

    arr[0] = prompt("Nuevo valor para el primer elemento:", arr[0]) || arr[0];
    guardarArray(arr);
    resultado.textContent = "Primer elemento modificado.";
  });

  // Eliminar el último elemento
  btnEliminar.addEventListener("click", () => {
    const arr = obtenerArray();
    if (arr.length === 0) {
      resultado.textContent = "No hay elementos para eliminar.";
      return;
    }

    const eliminado = arr.pop();
    guardarArray(arr);
    resultado.textContent = `Elemento "${eliminado}" eliminado.`;
  });

  // Vaciar el array
  btnReset.addEventListener("click", () => {
    localStorage.setItem("a", JSON.stringify([]));
    resultado.textContent = "El array ha sido vaciado.";
  });
});

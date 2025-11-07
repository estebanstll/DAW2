document.addEventListener("DOMContentLoaded", () => {
  const input = document.getElementById("valor");
  const resultado = document.getElementById("resultado");

  const btnAgregar = document.getElementById("agregar");
  const btnMostrar = document.getElementById("mostrar");
  const btnEliminar = document.getElementById("eliminar");
  const btnReset = document.getElementById("reset");

  // Inicializar el array en sessionStorage si no existe
  if (!sessionStorage.getItem("a")) {
    sessionStorage.setItem("a", JSON.stringify([]));
  }

  // Obtener el array actual
  function obtenerArray() {
    return JSON.parse(sessionStorage.getItem("a")) || [];
  }

  // Guardar el array actualizado
  function guardarArray(arr) {
    sessionStorage.setItem("a", JSON.stringify(arr));
  }

  // Agregar un elemento
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

  // Vaciar todo el array
  btnReset.addEventListener("click", () => {
    sessionStorage.setItem("a", JSON.stringify([]));
    resultado.textContent = "El array ha sido vaciado.";
  });
});

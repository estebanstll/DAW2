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
      resultado.textContent =
        "Contenido del array (" +
        arr.length +
        "): " +
        arr.map((v, i) => `[${i}]: ${v}`).join(", ");
    }
  });

  // Modificar elemento según posición ingresada
  btnModificar.addEventListener("click", () => {
    const posicion = parseInt(input.value.trim(), 10);

    if (isNaN(posicion)) {
      resultado.textContent =
        "Debes escribir una posición numérica válida para modificar.";
      return;
    }

    const arr = obtenerArray();

    if (posicion < 0 || posicion >= arr.length) {
      resultado.textContent = `La posición ${posicion} no existe.`;
      return;
    }

    const nuevoValor = prompt(
      `Nuevo valor para la posición [${posicion}] (actual: "${arr[posicion]}"):`,
      arr[posicion]
    );

    if (nuevoValor === null || nuevoValor.trim() === "") {
      resultado.textContent = "Operación cancelada o valor vacío.";
      return;
    }

    arr[posicion] = nuevoValor.trim();
    guardarArray(arr);
    resultado.textContent = `Elemento en posición [${posicion}] modificado a "${nuevoValor}".`;
    input.value = "";
  });

  // Eliminar elemento por valor
  btnEliminar.addEventListener("click", () => {
    const valor = input.value.trim();
    if (valor === "") {
      resultado.textContent = "Debes escribir el valor que deseas eliminar.";
      return;
    }

    const arr = obtenerArray();
    const nuevoArr = arr.filter((item) => item !== valor);

    if (nuevoArr.length === arr.length) {
      resultado.textContent = `El valor "${valor}" no se encontró en el array.`;
      return;
    }

    guardarArray(nuevoArr);
    resultado.textContent = `Elemento(s) "${valor}" eliminado(s) del array.`;
    input.value = "";
  });

  // Vaciar el array
  btnReset.addEventListener("click", () => {
    localStorage.setItem("a", JSON.stringify([]));
    resultado.textContent = "El array ha sido vaciado.";
  });
});

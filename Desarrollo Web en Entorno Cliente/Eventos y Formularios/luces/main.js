const container = document.getElementById("luces-container"); // contenedor de los lucess
const btnGenerar = document.getElementById("generar"); // botón para generar los lucess
const inputFilas = document.getElementById("filas"); // input para número de filas
const inputColumnas = document.getElementById("columnas");

function generarLuces() {
  const filas = parseInt(inputFilas.value);
  const columnas = parseInt(inputColumnas.value);
  container.innerHTML = "";

  container.style.display = "grid";
  container.style.gridTemplateColumns = `repeat(${columnas}, 50px)`; // cada luz mide 50px
  container.style.gridGap = "5px"; // espacio entre luces

  for (let i = 0; i < filas; i++) {
    for (let j = 0; j < columnas; j++) {
      const luces = document.createElement("div"); // creamos el div para el luces
      luces.classList.add("luces"); // añadimos la clase CSS "luces"
      luces.classList.add("encendido");
      luces.textContent = `${i + 1}-${j + 1}`; // opcional: mostramos el número de luces
      luces.dataset.fila = i; // guardamos la fila en un atributo data
      luces.dataset.columna = j; // guardamos la columna en un atributo data

      luces.addEventListener("click", () => {
        if (luces.classList.contains("encendido")) {
          luces.classList.remove("encendido");
          luces.classList.add("apagado");
        } else {
          luces.classList.remove("apagado");
          luces.classList.add("encendido");
        }
      });

      container.appendChild(luces);
    }
  }
}
btnGenerar.addEventListener("click", generarLuces);

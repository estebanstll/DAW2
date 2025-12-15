function analyzeNumbers(arrayInput) {
  let arrayNumeros = arrayInput.split(",");
  let pares = " ";
  let impares = " ";
  let numerosUnicos = " ";

  for (let index = 0; index < arrayNumeros.length; index++) {
    if (arrayNumeros[index] % 2 === 0) {
      pares += arrayNumeros[index] + ", ";
    } else {
      impares += arrayNumeros[index] + ", ";
    }
  }

  const mapa = new Map();

  for (let index = 0; index < arrayNumeros.length; index++) {
    if (mapa.get(arrayNumeros[index]) === undefined) {
      mapa.set(arrayNumeros[index], 1);
    } else {
      mapa.set(arrayNumeros[index], mapa.get(arrayNumeros[index]) + 1);
    }

    numerosUnicos = [...mapa.keys()];
  }

  const array = [];

  for (let index = 0; index < arrayNumeros.length; index++) {
    array.push(parseInt(arrayNumeros[index]));
  }
  const sortedValues = array.toSorted((a, b) => a - b);

  let sumaTotal = 0;

  for (let index = 0; index < array.length; index++) {
    sumaTotal += array[index];
  }

  return (
    "Lista original: " +
    arrayInput +
    " numeros pares: " +
    pares +
    " numeros impares: " +
    impares +
    " numeros unicos: " +
    numerosUnicos +
    " lista ordenada " +
    sortedValues +
    " suma total: " +
    sumaTotal
  );
}

const input = document.getElementById("cadena");
const boton = document.getElementById("Comprobar");
const output = document.getElementById("resultado");

boton.addEventListener("click", (e) => {
  e.preventDefault();
  output.textContent = "hola";
  output.textContent = analyzeNumbers(input.value);
});

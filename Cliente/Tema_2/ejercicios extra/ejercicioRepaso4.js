function trios(array) {
  let resultado = "Los indices de los 3 numeros cuya suma es 0 son: ";
  for (let i = 0; i < array.length; i++) {
    for (let j = 0; j < array.length; j++) {
      for (let k = 0; k < array.length; k++) {
        if (i != j && i != k && j != k) {
          if (array[i] + array[j] + array[k] == 0) {
            console.log("entre");

            resultado += "[" + i + ", " + j + ", " + k + "] ";
          }
        }
      }
    }
  }
  return resultado;
}

let numeros = [1, -1, 2, -2, 0];

console.log(trios(numeros));

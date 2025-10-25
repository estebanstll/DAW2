function ejercicio7(array) {
  let indice = 0;

  let encontrado = false;

  let resultadoDerecha;

  let resultadoIzquierda;

  while (indice < array.length && !encontrado) {
    resultadoDerecha = 0;
    resultadoIzquierda = 0;
    for (let i = 0; i < indice; i++) {
      //console.log(resultadoDerecha);
      resultadoDerecha += array[i];
    }

    for (let j = array.length - 1; j > indice; j--) {
      resultadoIzquierda += array[j];
      //console.log(resultadoIzquierda);
    }

    if (resultadoDerecha === resultadoIzquierda) {
      encontrado = true;
    } else {
      //console.log(indice);
      indice++;
    }
  }
  return encontrado;
}

console.log(ejercicio7([2, 3, 3, 2]));
console.log(ejercicio7([2, 3, 1, 3, 2]));

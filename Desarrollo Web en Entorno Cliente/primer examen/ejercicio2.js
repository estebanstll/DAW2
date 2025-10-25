function ejercicio2(input) {
  menorIndice = 0;
  menorIndiceResultado = Infinity;
  for (let index = 0; index < input.length; index++) {
    let contadorA = 0;
    let sumBucleA = 0;

    if (input.length === 1) {
      return "la diferencia media del indice " + 0 + " es: " + input[0];
    }
    for (let j = 0; j <= index; j++) {
      contadorA++;
      sumBucleA += input[j];
    }

    let contadorB = 0;
    let sumBucleB = 0;

    for (let k = input.length - 1; k > index; k--) {
      contadorB++;
      sumBucleB += input[k];
    }
    //console.log(sumBucleA);
    // console.log(sumBucleB);
    // console.log("---------------");

    let resultadoA = Math.floor(sumBucleA / contadorA);
    let resultadoB = Math.floor(sumBucleB / contadorB);

    let diferencia = Math.abs(resultadoA - resultadoB);
    if (diferencia < menorIndiceResultado) {
      menorIndice = index;
      menorIndiceResultado = diferencia;
    }
  }
  return (
    "la diferencia media del indice " +
    menorIndice +
    " es: " +
    menorIndiceResultado
  );
}

console.log(ejercicio2([2, 5, 3, 9, 5, 3]));
console.log(ejercicio2([3]));

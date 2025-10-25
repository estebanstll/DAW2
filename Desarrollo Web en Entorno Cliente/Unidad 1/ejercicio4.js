function buscarRepeticionesImpares(arrayNumeros) {
  let arrayNumeroRepeticionesImpares = [];

  for (let i = 0; i < arrayNumeros.length; i++) {
    let repeticiones = 0;

    for (let j = 0; j < arrayNumeros.length; j++) {
      if (arrayNumeros[i] === arrayNumeros[j]) {
        repeticiones++;
      }
    }
    if (repeticiones % 2 !== 0) {
      arrayNumeroRepeticionesImpares.push(arrayNumeros[i]);
    }
  }
  let stringResultado = "los numeros impares son: ";

  for (let i = 0; i < arrayNumeroRepeticionesImpares.length; i++) {
    stringResultado += arrayNumeroRepeticionesImpares[i] + ", ";
  }

  return stringResultado;
}

console.log(buscarRepeticionesImpares([2, 2, 2, 3, 3, 1]));

function arrayDiff(primerArray, segundoArray) {
  let arrayResultado = [];
  for (let i = 0; i < primerArray.length; i++) {
    let coincidencia = false;

    for (let j = 0; j < segundoArray.length; j++) {
      if (primerArray[i] === segundoArray[j]) {
        coincidencia = true;
      }
    }

    if (!coincidencia) {
      arrayResultado.push(primerArray[i]);
    }
  }

  return arrayResultado;
}

console.log(arrayDiff([1, 2, 2, 3, 2, 1, 3, 4], [1, 2, 3]));

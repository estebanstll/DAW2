function calcularMenorRepetido(arrayNumeros) {
  let numeroMenor = 0;
  let numeroMenorRepeticiones = Infinity;

  for (let i = 0; i < arrayNumeros.length; i++) {
    let repeticiones = 0;

    for (let index = 0; index < arrayNumeros.length; index++) {
      if (arrayNumeros[i] === arrayNumeros[index]) {
        repeticiones++;
      }
    }
    if (repeticiones < numeroMenorRepeticiones) {
      numeroMenor = arrayNumeros[i];
      numeroMenorRepeticiones = repeticiones;
    }
  }
  console.log(numeroMenor);
  return "el numero con menor repeticiones es el: " + numeroMenor;
}

console.log(calcularMenorRepetido([2, 3, 3, 2]));

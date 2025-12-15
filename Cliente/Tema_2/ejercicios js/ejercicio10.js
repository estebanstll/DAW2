function binario(numero) {
  let numeroADividir = numero;
  let divisionesResultados = [];

  if (numeroADividir < 0) {
    console.log("el numero tiene que ser positivo");
  } else {
    while (numeroADividir > 0) {
      if (numeroADividir % 2 == 0) {
        divisionesResultados.push(0);
      } else {
        divisionesResultados.push(numeroADividir % 2);
      }
      numeroADividir = Math.trunc(numeroADividir / 2);
    }
  }

  //console.log(divisionesResultados);

  let cantidadDeUnos = 0;
  for (let index = 0; index < divisionesResultados.length; index++) {
    if (divisionesResultados[index] == 1) {
      cantidadDeUnos++;
    }
  }

  console.log("Hay un total de " + cantidadDeUnos + " unos en su binario.");
}
binario(9);

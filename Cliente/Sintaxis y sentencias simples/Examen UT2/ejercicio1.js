function rango(izquerda, derecha) {
  let arrayResultado = [];
  let cantidad = 0;
  for (let index = izquerda; index <= derecha; index++) {
    let divisionesResultados = [];
    let numeroADividir = index;
    while (numeroADividir > 0) {
      if (numeroADividir % 2 == 0) {
        divisionesResultados.push(0);
      } else {
        divisionesResultados.push(numeroADividir % 2);
      }
      numeroADividir = Math.trunc(numeroADividir / 2);
    }
    let cantidadDeUnos = 0;

    for (let index = 0; index < divisionesResultados.length; index++) {
      if (divisionesResultados[index] == 1) {
        cantidadDeUnos++;
      }
    }

    let esPrimo = 0;
    for (let i = 1; i <= cantidadDeUnos; i++) {
      if (cantidadDeUnos % i === 0) {
        esPrimo++;
      }
    }

    if (esPrimo === 2) {
      cantidad++;
    } else {
    }
  }

  console.log(cantidad);
}

rango(10, 15);

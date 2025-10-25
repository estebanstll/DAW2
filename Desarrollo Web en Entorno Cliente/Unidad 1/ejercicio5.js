//tiene que devolver solo el primero, el resto de repeticiones fuera

function devolverNoRepetidos(cadena) {
  const arrayCadena = cadena.split("");
  let cadenadevuelta = "";
  for (let index = 0; index < arrayCadena.length; index++) {
    let repetida = false;

    for (let j = 0; j < arrayCadena.length; j++) {
      if (arrayCadena[index] === arrayCadena[j] && index != j) {
        if (index > j) {
          repetida = true;
        }
      }
    }
    //console.log(repetida);
    if (repetida == false) {
      cadenadevuelta += arrayCadena[index];
    }
  }

  return cadenadevuelta;
}

console.log(devolverNoRepetidos("hola que tal"));

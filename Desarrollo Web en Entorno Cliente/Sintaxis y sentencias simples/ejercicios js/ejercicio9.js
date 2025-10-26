// no va, problemas para reordenar un numero a mayor y a menor si esl numwro que ha habido hace 2 operaciones es menor o mayor

function reordenarNumeros(numeroEntrada) {
  if (numeroEntrada < 0) {
    console.log("el numero tiene que ser positivo");
  }
  const cadena = numeroEntrada + "";
  let arrayNumero = cadena.split("");
  let numeroLeido = [];
  let resultado = "";
  for (let index = 0; index < arrayNumero.length; index++) {
    if (numeroLeido >= arrayNumero[index]) {
      resultado += arrayNumero[index];
      numeroLeido = arrayNumero[index];
    } else {
      resultado = arrayNumero[index] + resultado;
      numeroLeido = arrayNumero[index];
    }
  }
  console.log(resultado);
}
reordenarNumeros(23312);

/*


let esMayor = false;

    for (let j = 0; j < arrayNumero.length; j++) {
      if (arrayNumero[index] > arrayNumero[j]) {
        esMayor = true;
      }
    }
    console.log(esMayor);
    if (resultado) {
      resultado += arrayNumero[index];
    }


*/

function subcadenasCorta(cadena) {
  let subcadena = cadena.split(" ");

  let cadenaMaslargaSinRepeticiones = "";
  let caracteresDeLaCadenaMasLargaSinRepeticiones = 0;

  for (let index = 0; index < subcadena.length; index++) {
    let palabraComparando = subcadena[index];

    let arraypalabra = palabraComparando.split("");
    let caracteresSinRepetir = 0;
    let repetidas = false;
    for (let i = 0; i < arraypalabra.length; i++) {
      for (let j = 0; j < arraypalabra.length; j++) {
        if (arraypalabra[i] != arraypalabra[j]) {
          caracteresSinRepetir++;
        }

        if (i != j && arraypalabra[i] === arraypalabra[j]) {
          repetidas = true;
        }
      }
    }

    if (
      caracteresSinRepetir > caracteresDeLaCadenaMasLargaSinRepeticiones &&
      !repetidas
    ) {
      caracteresDeLaCadenaMasLargaSinRepeticiones = caracteresSinRepetir;
      cadenaMaslargaSinRepeticiones = palabraComparando;
    }
  }

  return (
    " la palabra mas larga sin caracteres repetidos es: " +
    cadenaMaslargaSinRepeticiones
  );
}
console.log(subcadenasCorta("holaa buenoss dias compaee "));

function persistenciaMultiplicativa(numero) {
  let numeroResutado = numero;
  let num = "" + numero;
  let arrayDigito = num.split("");
  let resultado = 0;
  let multiplicacion;

  if (numeroResutado < 0) {
    return "introduce un numero positivo";
  }
  if (numeroResutado < 10) {
    return resultado;
  } else {
    while (numeroResutado >= 10) {
      multiplicacion = 1;

      for (let index = 0; index < arrayDigito.length; index++) {
        multiplicacion *= arrayDigito[index];
      }
      resultado++;

      numeroResutado = multiplicacion;
      num = multiplicacion + "";
      arrayDigito = num.split("");
    }
  }
  return resultado;
}
console.log(persistenciaMultiplicativa(999));

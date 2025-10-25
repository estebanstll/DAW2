function cadenasCercanas(cadenaUno, cadenaDos) {
  const cadenaUnoArray = cadenaUno.split("");
  const cadenaDosArray = cadenaDos.split("");
  let noEsta = 0;
  let esta = 0;
  for (let i = 0; i < cadenaUnoArray.length; i++) {
    for (let j = 0; j < cadenaDosArray.length; j++) {
      if (cadenaUnoArray[i] !== cadenaDosArray[j]) {
        noEsta++;
      } else {
        esta++;
      }
    }
  }

  if (esta > noEsta) {
    return "la cadena se parece";
  } else {
    return "las cadenas no se parecen";
  }
}

console.log(cadenasCercanas("hola", "aloh"));

// ora idea era haciendo con expresiones irregulares

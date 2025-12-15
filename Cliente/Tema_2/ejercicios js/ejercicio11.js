function cuatroCuadrados(n) {
  const limite = Math.floor(Math.sqrt(n)) + 1;

  const arrayDigito = Array.from({ length: limite }, (_, i) => i);

  for (let aIndex = 0; aIndex < arrayDigito.length; aIndex++) {
    let a = arrayDigito[aIndex];
    for (let bIndex = 0; bIndex < arrayDigito.length; bIndex++) {
      let b = arrayDigito[bIndex];
      for (let cIndex = 0; cIndex < arrayDigito.length; cIndex++) {
        let c = arrayDigito[cIndex];
        for (let dIndex = 0; dIndex < arrayDigito.length; dIndex++) {
          let d = arrayDigito[dIndex];
          if (a * a + b * b + c * c + d * d === n) {
            return [a, b, c, d];
          }
        }
      }
    }
  }

  return null;
}

// Ejemplo de uso
const numero = 9999999999999999;
const resultado = cuatroCuadrados(numero);
console.log(resultado);

/*


El teorema de los cuatro cuadrados de Lagrange, también conocido
como conjetura de Bachet, afirma que todo número natural puede
representarse como la suma de cuatro cuadrados enteros.
Haz una función que devuelva un array con los cuatro números naturales
que cumplan el teorema dado un número natural pasado como argumento.


function Lagrange(num) {
let lag = 0;
let nums = [];
for (i = 1; i <= 4; i++) {
lag = parseInt(Math.sqrt(num));
nums.push(lag);
num = num - Math.pow(lag, 2);
}
console.log(nums);
}

Lagrange(9999999999999999);



*/

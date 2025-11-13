// ✅ Añade funcionalidad extra sin modificar la función original
function loggear(fn) {
  return function (...args) {
    console.log("Ejecutando:", fn.name);
    return fn(...args);
  };
}

function sumar(a, b) {
  return a + b;
}

const sumarConLog = loggear(sumar);
console.log(sumarConLog(3, 2)); // Ejecutando: sumar → 5

// 💬 Se usa para extender comportamientos (logging, validación, permisos...)
// sin alterar el código base.

// ✅ Garantiza que solo exista una instancia (por ejemplo, configuración global)
const Configuracion = (function () {
  let instancia;

  function crearInstancia() {
    return { modo: "producción", puerto: 8080 };
  }

  return {
    getInstancia: function () {
      if (!instancia) instancia = crearInstancia();
      return instancia;
    },
  };
})();

const c1 = Configuracion.getInstancia();
const c2 = Configuracion.getInstancia();

console.log(c1 === c2); // true — misma instancia

// 💬 Se usa cuando queremos un solo punto de acceso (config, logger, conexión...)
// evitando múltiples copias del mismo recurso.

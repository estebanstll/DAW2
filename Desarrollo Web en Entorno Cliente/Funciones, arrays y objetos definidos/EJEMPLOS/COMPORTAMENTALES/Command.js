// ✅ Encapsula acciones como objetos — útil para deshacer o macros
class Encender {
  execute() {
    console.log("💡 Encendiendo");
  }
  undo() {
    console.log("💡 Apagando");
  }
}

class Control {
  ejecutar(cmd) {
    cmd.execute();
  }
  deshacer(cmd) {
    cmd.undo();
  }
}

const control = new Control();
const comando = new Encender();

control.ejecutar(comando);
control.deshacer(comando);

// 💬 Se usa cuando queremos separar quién ejecuta la acción de quién la define,
// o necesitamos registrar/deshacer acciones.

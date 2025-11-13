// ✅ Adapta una interfaz antigua a una nueva sin tocar el código original
class OldPrinter {
  print(t) {
    console.log(`Imprimiendo: ${t}`);
  }
}

class PrinterAdapter {
  constructor(oldPrinter) {
    this.oldPrinter = oldPrinter;
  }

  printText(text) {
    this.oldPrinter.print(text);
  }
}

const adapter = new PrinterAdapter(new OldPrinter());
adapter.printText("Documento PDF");

// 💬 Se usa para conectar código viejo con uno nuevo,
// evitando reescribir sistemas que ya funcionan.

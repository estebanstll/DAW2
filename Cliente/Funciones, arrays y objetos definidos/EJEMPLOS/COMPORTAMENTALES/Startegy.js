// ✅ Permite intercambiar algoritmos sin tocar el código principal
class PagoTarjeta {
  pagar(monto) {
    console.log(`Pagando $${monto} con tarjeta 💳`);
  }
}

class PagoPayPal {
  pagar(monto) {
    console.log(`Pagando $${monto} con PayPal 🪙`);
  }
}

class ContextoPago {
  setEstrategia(e) {
    this.e = e;
  }
  ejecutar(monto) {
    this.e.pagar(monto);
  }
}

const pago = new ContextoPago();
pago.setEstrategia(new PagoTarjeta());
pago.ejecutar(100);
pago.setEstrategia(new PagoPayPal());
pago.ejecutar(200);

// 💬 Se usa cuando hay varias formas de hacer algo (diferentes algoritmos),
// y queremos poder cambiarlas en tiempo de ejecución.

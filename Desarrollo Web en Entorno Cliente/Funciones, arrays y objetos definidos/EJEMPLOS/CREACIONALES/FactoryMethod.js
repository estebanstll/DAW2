// ✅ Crea objetos sin acoplar el código a clases concretas
class Vehiculo {
  conducir() {}
}

class Auto extends Vehiculo {
  conducir() {
    console.log("Conduciendo un auto 🚗");
  }
}

class Moto extends Vehiculo {
  conducir() {
    console.log("Conduciendo una moto 🏍️");
  }
}

class VehiculoFactory {
  static crear(tipo) {
    if (tipo === "auto") return new Auto();
    if (tipo === "moto") return new Moto();
    throw new Error("Tipo no válido");
  }
}

const v = VehiculoFactory.crear("moto");
v.conducir();

// 💬 Se usa para centralizar la creación de objetos y poder cambiar implementaciones
// sin modificar el código cliente.

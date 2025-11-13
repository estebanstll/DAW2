// ✅ Construye objetos complejos paso a paso
class PCBuilder {
  constructor() {
    this.pc = {};
  }

  setCPU(cpu) {
    this.pc.cpu = cpu;
    return this;
  }
  setRAM(ram) {
    this.pc.ram = ram;
    return this;
  }
  setGPU(gpu) {
    this.pc.gpu = gpu;
    return this;
  }

  build() {
    return this.pc;
  }
}

const pcGamer = new PCBuilder()
  .setCPU("i9")
  .setRAM("32GB")
  .setGPU("RTX 4080")
  .build();

console.log(pcGamer);

// 💬 Se usa cuando un objeto tiene muchas propiedades opcionales,
// y queremos un código legible tipo “receta”.

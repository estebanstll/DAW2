// ✅ Un objeto notifica a otros cuando cambia
class Evento {
  constructor() {
    this.obs = [];
  }
  suscribir(fn) {
    this.obs.push(fn);
  }
  notificar(data) {
    this.obs.forEach((fn) => fn(data));
  }
}

const evento = new Evento();

evento.suscribir((msg) => console.log("📩 Receptor 1:", msg));
evento.suscribir((msg) => console.log("📩 Receptor 2:", msg));

evento.notificar("Nuevo mensaje disponible");

// 💬 Se usa cuando un cambio debe avisar a muchos (sistemas reactivos, interfaces dinámicas...).

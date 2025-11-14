export class Pokemon {
  constructor({ id, nombre, tipo, nivel, eliminado = false }) {
    this.id = id;
    this.nombre = nombre;
    this.tipo = tipo;
    this.nivel = Number(nivel);
    this.eliminado = !!eliminado;
  }

  toString() {
    return `${this.nombre} (${this.tipo}) - N°${this.id}`;
  }
}

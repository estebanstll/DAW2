export default class libro {
  constructor(nombre, autor, paginas, estaPrestado) {
    this.nombre = nombre;
    this.autor = autor;
    this.paginas = paginas;
    this.estaPrestado = estaPrestado;
  }
  toString() {
    const estado = this.estaPrestado ? "Sí" : "No";
    return `Título: ${this.nombre}\nAutor: ${this.autor}\nPáginas: ${this.paginas}\n¿Está prestado?: ${estado}`;
  }
}

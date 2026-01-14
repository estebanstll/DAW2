const crypto = require("crypto");
class Task {
  constructor(nombre, fecha, descripcion) {
    this.nombre = nombre;
    this.fecha = fecha;
    this.descripcion = descripcion;
    this.id = generateUUID();
  }
  static createTask(nombre, fecha, descripcion, id) {
    const task = new Task();
    task.nombre = nombre;
    task.fecha = fecha;
    task.descripcion = descripcion;
    task.id = id;
    return task;
  }
}

function generateUUID() {
  return crypto.randomUUID();
}

module.exports = Task;

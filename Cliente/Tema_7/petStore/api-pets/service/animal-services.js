const { MongoClient } = require("mongodb");
const Animal = require("../models/animal");

class animalService {
  // Configuración centralizada
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "animalDB";
  static COLLECTION_NAME = "animal";

  // Método auxiliar para ejecutar operaciones con la base de datos
  static async executeWithDb(callback) {
    const client = new MongoClient(this.URI);
    try {
      await client.connect();
      const collection = client
        .db(this.DB_NAME)
        .collection(this.COLLECTION_NAME);
      return await callback(collection);
    } catch (error) {
      console.error("Error en la operación de base de datos:", error);
      throw error;
    } finally {
      await client.close();
    }
  }

  static async get() {
    return this.executeWithDb((collection) => collection.find().toArray());
  }

  static async getByName(nombre) {
    return this.executeWithDb((collection) =>
      collection.findOne({ nombre: { $regex: `^${nombre}$`, $options: "i" } }),
    );
  }

  static async post(nombre, estado, descripcion, img) {
    return this.executeWithDb(async (collection) => {
      const nuevoAnimal = new Animal(nombre, estado, descripcion, img);
      const result = await collection.insertOne(nuevoAnimal);
      console.log("POST animal ejecutado");
      return { _id: result.insertedId, ...nuevoAnimal };
    });
  }

  static async delete(nombre) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({ nombre: { $regex: `^${nombre}$`, $options: "i" } });
      return result.deletedCount > 0;
    });
  }

  static async update(nombre, estado, descripcion, img) {
    return this.executeWithDb(async (collection) => {
      const datosActualizados = {};
      if (estado !== undefined) datosActualizados.estado = estado;
      if (descripcion !== undefined)
        datosActualizados.descripcion = descripcion;
      if (img !== undefined) datosActualizados.img = img;

      const result = await collection.updateOne(
        { nombre: { $regex: `^${nombre}$`, $options: "i" } },
        { $set: datosActualizados },
      );
      return result.modifiedCount > 0;
    });
  }
}

module.exports = animalService;

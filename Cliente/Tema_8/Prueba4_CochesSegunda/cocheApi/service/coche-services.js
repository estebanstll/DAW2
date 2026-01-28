const { MongoClient } = require("mongodb");
const coche = require("../models/cocheModels");

class cocheService {
  // Configuración centralizada
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "cocheDB";
  static COLLECTION_NAME = "coche";

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

  static async getByName(marca) {
    return this.executeWithDb((collection) =>
      collection.findOne({ marca: { $regex: `^${marca}$`, $options: "i" } }),
    );
  }

  static async post(marca, modelo, img) {
    return this.executeWithDb(async (collection) => {
      const nuevocoche = new coche(marca, modelo, img);
      const result = await collection.insertOne(nuevocoche);
      console.log("POST coche ejecutado");
      return { _id: result.insertedId, ...nuevocoche };
    });
  }

  static async delete(marca) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({
        marca: { $regex: `^${marca}$`, $options: "i" },
      });
      return result.deletedCount > 0;
    });
  }

  static async update(marca, modelo, img) {
    return this.executeWithDb(async (collection) => {
      const datosActualizados = {};
      if (modelo !== undefined) datosActualizados.modelo = modelo;
      if (img !== undefined) datosActualizados.img = img;

      const result = await collection.updateOne(
        { marca: { $regex: `^${marca}$`, $options: "i" } },
        { $set: datosActualizados },
      );
      return result.modifiedCount > 0;
    });
  }
}

module.exports = cocheService;

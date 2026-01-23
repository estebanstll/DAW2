const { MongoClient } = require("mongodb");
const log = require("../models/logsModel");

class logService {
  // Configuración centralizada
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "logDB";
  static COLLECTION_NAME = "log";

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

  static async getByDate(fecha) {
    return this.executeWithDb((collection) =>
      collection.findOne({ fecha: { $regex: `^${fecha}$`, $options: "i" } }),
    );
  }

  static async post(mensaje, nivel, fecha) {
    return this.executeWithDb(async (collection) => {
      const nuevolog = new log(mensaje, nivel, fecha);
      const result = await collection.insertOne(nuevolog);
      console.log("POST log ejecutado");
      return { _id: result.insertedId, ...nuevolog };
    });
  }
}

module.exports = logService;

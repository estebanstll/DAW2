const { MongoClient } = require("mongodb");
const usuario = require("../models/usuarioModel");

class usuarioService {
  // Configuración centralizada
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "usuarioDB";
  static COLLECTION_NAME = "usuario";

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

  static async post(nombre, contraseña) {
    return this.executeWithDb(async (collection) => {
      const nuevoUsuario = new usuario(nombre, contraseña);
      const result = await collection.insertOne(nuevoUsuario);
      console.log("POST usuario ejecutado");
      return { _id: result.insertedId, ...nuevoUsuario };
    });
  }
}

module.exports = usuarioService;

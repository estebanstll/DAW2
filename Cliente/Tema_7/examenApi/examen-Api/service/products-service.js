const { MongoClient } = require("mongodb");
const Product = require("../models/productosModel");

class ProductService {
  // Configuración centralizada
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "productDB";
  static COLLECTION_NAME = "products";

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

  static async getByName(name) {
    return this.executeWithDb((collection) =>
      collection.findOne({ name: { $regex: `^${name}$`, $options: "i" } }),
    );
  }

  static async getById(id) {
    return this.executeWithDb((collection) =>
      collection.findOne({ id: parseInt(id) }),
    );
  }

  static async post(id, name, description, price, user) {
    return this.executeWithDb(async (collection) => {
      const nuevoProducto = new Product(id, name, description, price, user);
      const result = await collection.insertOne(nuevoProducto);
      console.log("POST producto ejecutado");
      return { _id: result.insertedId, ...nuevoProducto };
    });
  }

  static async delete(name) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({
        name: { $regex: `^${name}$`, $options: "i" },
      });
      return result.deletedCount > 0;
    });
  }

  static async deleteById(id) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({
        id: parseInt(id),
      });
      return result.deletedCount > 0;
    });
  }
}

module.exports = ProductService;

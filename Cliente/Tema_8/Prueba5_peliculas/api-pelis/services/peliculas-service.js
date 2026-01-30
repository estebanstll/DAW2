const { MongoClient } = require("mongodb");
const Pelicula = require("../models/peliculasModel");

class PeliculasService {
  static URI = "mongodb://mongoadmin:secret@localhost:27017";
  static DB_NAME = "peliculasDB";
  static COLLECTION_NAME = "peliculas";

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

  static async getById(id) {
    return this.executeWithDb((collection) =>
      collection.findOne({ id: parseInt(id) }),
    );
  }

  static async post(id, titulo, anio, genero, valoracion, plataforma, img) {
    return this.executeWithDb(async (collection) => {
      const nuevaPelicula = new Pelicula(
        parseInt(id),
        titulo,
        anio,
        genero,
        valoracion,
        plataforma,
        img,
      );
      const result = await collection.insertOne(nuevaPelicula);
      console.log("POST pelicula ejecutado");
      return { _id: result.insertedId, ...nuevaPelicula };
    });
  }

  static async deleteById(id) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({ id: parseInt(id) });
      return result.deletedCount > 0;
    });
  }

  static async put(id, updatedFields) {
    return this.executeWithDb(async (collection) => {
      const result = await collection.findOneAndUpdate(
        { id: parseInt(id) },
        { $set: updatedFields },
        { returnDocument: "after" },
      );
      return result.value;
    });
  }
}

module.exports = PeliculasService;

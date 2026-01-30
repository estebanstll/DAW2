const { MongoClient } = require("mongodb");
const Album = require("../models/albumModel");

class AlbumService {
  static URI = "mongodb://usemongo:secretoarab@localhost:27017";
  static DB_NAME = "music_library_db";
  static COLLECTION_NAME = "albums";

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
    const ObjectId = require("mongodb").ObjectId;
    return this.executeWithDb((collection) =>
      collection.findOne({ _id: new ObjectId(id) }),
    );
  }

  static async post(titulo, artista, anio, genero, img) {
    return this.executeWithDb(async (collection) => {
      const nuevoAlbum = new Album(titulo, artista, anio, genero, img);
      const result = await collection.insertOne(nuevoAlbum);
      console.log("POST album ejecutado");
      return { _id: result.insertedId, ...nuevoAlbum };
    });
  }

  static async deleteById(id) {
    const ObjectId = require("mongodb").ObjectId;
    return this.executeWithDb(async (collection) => {
      const result = await collection.deleteOne({ _id: new ObjectId(id) });
      return result.deletedCount > 0;
    });
  }

  static async put(id, updatedFields) {
    const ObjectId = require("mongodb").ObjectId;
    return this.executeWithDb(async (collection) => {
      const result = await collection.findOneAndUpdate(
        { _id: new ObjectId(id) },
        { $set: updatedFields },
        { returnDocument: "after" },
      );
      return result.value;
    });
  }
}

module.exports = AlbumService;

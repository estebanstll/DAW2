const { MongoClient } = require("mongodb");
const Cancion = require("../models/cancionModel");

class CancionService {
  static URI = "mongodb://usemongo:secretoarab@localhost:27017";
  static DB_NAME = "music_library_db";
  static COLLECTION_NAME = "canciones";

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

  static async getByAlbumId(albumID) {
    const ObjectId = require("mongodb").ObjectId;
    return this.executeWithDb((collection) =>
      collection.find({ albumID: new ObjectId(albumID) }).toArray(),
    );
  }

  static async post(titulo, duracion, rating, albumID, escuchado) {
    const ObjectId = require("mongodb").ObjectId;
    return this.executeWithDb(async (collection) => {
      // Convertir albumID a ObjectId si es una cadena válida, o usarlo como está
      let albumIDConverted;
      try {
        albumIDConverted =
          typeof albumID === "string" && albumID.length === 24
            ? new ObjectId(albumID)
            : albumID;
      } catch (e) {
        // Si no se puede convertir, usar como está
        albumIDConverted = albumID;
      }

      const nuevaCancion = new Cancion(
        titulo,
        duracion,
        rating,
        albumIDConverted,
        escuchado,
      );
      const result = await collection.insertOne(nuevaCancion);
      console.log("POST cancion ejecutado");
      return { _id: result.insertedId, ...nuevaCancion };
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

module.exports = CancionService;

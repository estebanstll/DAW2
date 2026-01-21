const Libro = require("../models/libro");
const { MongoClient, ObjectId } = require("mongodb");

class LibroService {
  static async get() {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("LibroDB");
      const LibrosDB = database.collection("Libros");

      const Libros = await LibrosDB.find().toArray();

      return Libros;
    } finally {
      await client.close();
    }
  }

  static async getById(id) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("LibroDB");
      const LibrosDB = database.collection("Libros");

      const Libro = await LibrosDB.findOne({ _id: new ObjectId(id) });

      return Libro;
    } finally {
      await client.close();
    }
  }

  static async post(titulo, autor, anio) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("LibroDB");
      const LibrosDB = database.collection("Libros");

      const result = await LibrosDB.insertOne({ titulo, autor, anio });

      return { _id: result.insertedId, titulo, autor, anio };
    } finally {
      await client.close();
    }
  }

  static async delete(id) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("LibroDB");
      const LibrosDB = database.collection("Libros");

      const result = await LibrosDB.deleteOne({ _id: new ObjectId(id) });

      return result.deletedCount > 0;
    } finally {
      await client.close();
    }
  }

  static async update(id, titulo, autor, anio) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("LibroDB");
      const LibrosDB = database.collection("Libros");

      const result = await LibrosDB.updateOne(
        { _id: new ObjectId(id) },
        { $set: { titulo, autor, anio } },
      );

      return result.modifiedCount > 0;
    } finally {
      await client.close();
    }
  }
}

module.exports = LibroService;

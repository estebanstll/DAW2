const Task = require("../model/task");
const { MongoClient, ObjectId } = require("mongodb");

class TaskService {
  static async get() {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("TaskDB");
      const tasksDB = database.collection("tasks");

      const tasks = await tasksDB.find().toArray();

      return tasks;
    } finally {
      await client.close();
    }
  }

  static async getById(id) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("TaskDB");
      const tasksDB = database.collection("tasks");

      const task = await tasksDB.findOne({ _id: new ObjectId(id) });

      return task;
    } finally {
      await client.close();
    }
  }

  static async post(titulo, autor, anio) {
    const uri = "mongodb://mongoadmin:secret@localhost:27017";
    const client = new MongoClient(uri);
    try {
      await client.connect();
      const database = client.db("TaskDB");
      const tasksDB = database.collection("tasks");

      const result = await tasksDB.insertOne({ titulo, autor, anio });

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
      const database = client.db("TaskDB");
      const tasksDB = database.collection("tasks");

      const result = await tasksDB.deleteOne({ _id: new ObjectId(id) });

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
      const database = client.db("TaskDB");
      const tasksDB = database.collection("tasks");

      const result = await tasksDB.updateOne(
        { _id: new ObjectId(id) },
        { $set: { titulo, autor, anio } }
      );

      return result.modifiedCount > 0;
    } finally {
      await client.close();
    }
  }
}

module.exports = TaskService;

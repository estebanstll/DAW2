let Libro = require("../models/libro");
var express = require("express");
var router = express.Router();
let taskService = require("../service/task-services");

// GET /libros
router.get("/", async function (req, res) {
  const libreria = await taskService.get();
  res.json(libreria);
});

// POST /libros
router.post("/", async function (req, res) {
  try {
    const libro = new Libro(req.body.titulo, req.body.autor, req.body.anio);
    const post = await taskService.post(libro.titulo, libro.autor, libro.anio);
    res.status(201).json(post);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el libro" });
  }
});

// PUT /libros/:titulo
router.put("/:titulo", async function (req, res) {
  res.json(req.body);
});

// DELETE /libros/:titulo
router.delete("/:id", async function (req, res) {
  const eliminar = taskService.delete(req.params.id);
  res.status(204).send();
});

module.exports = router;

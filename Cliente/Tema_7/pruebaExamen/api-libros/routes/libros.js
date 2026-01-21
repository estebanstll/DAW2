let Libro = require("../models/libro.js");
var express = require("express");
var router = express.Router();

const libros = [];

// GET /libros
router.get("/", function (req, res, next) {
  res.json(libros);
});

// POST /libros
router.post("/", function (req, res) {
  let libro = new Libro(req.body.titulo, req.body.autor, req.body.anio);
  libros.push(libro);
  res.status(201).json(libro);
});

// PUT /libros/:titulo
router.put("/:titulo", function (req, res) {
  const titulo = req.params.titulo;
  const libro = libros.find((l) => l.titulo === titulo);

  if (!libro) {
    return res.status(404).json({ message: "Libro no encontrado" });
  }

  libro.titulo = req.body.titulo;
  libro.autor = req.body.autor;
  libro.anio = req.body.anio;

  res.json(libro);
});

// DELETE /libros/:titulo
router.delete("/:titulo", function (req, res) {
  const titulo = req.params.titulo;
  const index = libros.findIndex((l) => l.titulo === titulo);

  if (index === -1) {
    return res.status(404).json({ message: "Libro no encontrado" });
  }

  libros.splice(index, 1);
  res.status(204).send();
});

module.exports = router;

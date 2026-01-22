let Animal = require("../models/animal");
var express = require("express");
var router = express.Router();

const animales = [];

// GET /animal
router.get("/", function (req, res) {
  res.json(animales);
});

// POST /animal
router.post("/", function (req, res) {
  try {
    const animal = new Animal(
      req.body.nombre,
      req.body.estado,
      req.body.descripcion,
      req.body.img,
    );

    animales.push(animal);
    res.status(201).json(animal);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el animal" });
  }
});

// PUT /animal/:nombre
router.put("/:nombre", function (req, res) {
  const nombre = req.params.nombre;
  const index = animales.findIndex((a) => a.nombre === nombre);

  if (index === -1) {
    return res.status(404).json({ error: "Animal no encontrado" });
  }

  animales[index] = {
    ...animales[index],
    ...req.body,
  };

  res.json(animales[index]);
});

// DELETE /animal/:nombre
router.delete("/:nombre", function (req, res) {
  const nombre = req.params.nombre;
  const index = animales.findIndex((a) => a.nombre === nombre);

  if (index === -1) {
    return res.status(404).json({ error: "Animal no encontrado" });
  }

  animales.splice(index, 1);
  res.status(204).send();
});

module.exports = router;

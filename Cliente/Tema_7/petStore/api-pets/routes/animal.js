let Animal = require("../models/animal");
let AnimalService = require("../service/animal-services");

var express = require("express");
var router = express.Router();

// GET /animal
router.get("/", async function (req, res) {
  try {
    const animales = await AnimalService.get();
    res.status(201).json(animales);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los animales" });
  }
});

router.get("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    console.log("Buscando:", nombre);
    const animal = await AnimalService.getByName(nombre);
    console.log("Resultado:", animal);

    if (!animal) {
      return res.status(404).json({ error: "Animal no encontrado" });
    }

    res.json(animal);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el animal", detalles: error.message });
  }
});

// POST /animal
router.post("/", async function (req, res) {
  try {
    const nuevoAnimal = await AnimalService.post(
      req.body.nombre,
      req.body.estado,
      req.body.descripcion,
      req.body.img,
    );
    res.status(201).json(nuevoAnimal);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el animal" });
  }
});

// PUT /animal/:nombre
router.put("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const actualizado = await AnimalService.update(
      nombre,
      req.body.estado,
      req.body.descripcion,
      req.body.img,
    );

    if (actualizado) {
      const animalActualizado = await AnimalService.getByName(nombre);
      res.json({ mensaje: "Animal actualizado", animal: animalActualizado });
    } else {
      res.status(404).json({ error: "Animal no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al actualizar el animal" });
  }
});

// DELETE /animal/:nombre
router.delete("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const animalEliminado = await AnimalService.getByName(nombre);

    if (!animalEliminado) {
      return res.status(404).json({ error: "Animal no encontrado" });
    }

    const eliminado = await AnimalService.delete(nombre);

    if (eliminado) {
      res.json({ mensaje: "Animal eliminado", animal: animalEliminado });
    } else {
      res.status(404).json({ error: "Animal no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el animal" });
  }
});

module.exports = router;

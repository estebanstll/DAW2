let Cancion = require("../models/cancionModel");
const CancionService = require("../service/cancion-service");

var express = require("express");
var router = express.Router();

// GET /canciones
router.get("/", async function (req, res) {
  try {
    const canciones = await CancionService.get();
    res.status(200).json(canciones);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener las canciones" });
  }
});

// GET /canciones/:id
router.get("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    console.log("Buscando cancion:", id);
    const cancion = await CancionService.getById(id);
    console.log("Resultado:", cancion);

    if (!cancion) {
      return res.status(404).json({ error: "Cancion no encontrada" });
    }

    res.json(cancion);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener la cancion", detalles: error.message });
  }
});

// POST /canciones
router.post("/", async function (req, res) {
  try {
    const nuevaCancion = await CancionService.post(
      req.body.titulo,
      req.body.duracion,
      req.body.rating,
      req.body.albumID,
      req.body.escuchado,
    );
    res.status(201).json(nuevaCancion);
  } catch (error) {
    console.error("Error en POST cancion:", error);
    res
      .status(500)
      .json({ error: "Error al crear la cancion", detalles: error.message });
  }
});

// DELETE /canciones/:id
router.delete("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const cancionEliminada = await CancionService.getById(id);

    if (!cancionEliminada) {
      return res.status(404).json({ error: "Cancion no encontrada" });
    }

    const eliminado = await CancionService.deleteById(id);

    if (eliminado) {
      res.json({ mensaje: "Cancion eliminada", cancion: cancionEliminada });
    } else {
      res.status(404).json({ error: "Cancion no encontrada" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar la cancion" });
  }
});

// PUT /canciones/:id
router.put("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const cancionExistente = await CancionService.getById(id);

    if (!cancionExistente) {
      return res.status(404).json({ error: "Cancion no encontrada" });
    }

    const updatedFields = {
      titulo: req.body.titulo ?? cancionExistente.titulo,
      duracion: req.body.duracion ?? cancionExistente.duracion,
      rating: req.body.rating ?? cancionExistente.rating,
      albumID: req.body.albumID ?? cancionExistente.albumID,
      escuchado: req.body.escuchado ?? cancionExistente.escuchado,
    };

    const cancionActualizada = await CancionService.put(id, updatedFields);
    res.json(cancionActualizada);
  } catch (error) {
    res.status(500).json({
      error: "Error al actualizar la cancion",
      detalles: error.message,
    });
  }
});

module.exports = router;

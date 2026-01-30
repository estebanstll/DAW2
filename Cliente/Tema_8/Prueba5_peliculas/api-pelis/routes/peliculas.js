let pelicula = require("../models/peliculasModel");
const peliculaService = require("../services/peliculas-service");

var express = require("express");
var router = express.Router();

// GET /pelicula
router.get("/", async function (req, res) {
  try {
    const peliculaes = await peliculaService.get();
    res.status(200).json(peliculaes);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los peliculas" });
  }
});

router.get("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    console.log("Buscando:", id);
    const pelicula = await peliculaService.getById(id);
    console.log("Resultado:", pelicula);

    if (!pelicula) {
      return res.status(404).json({ error: "pelicula no encontrado" });
    }

    res.json(pelicula);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el pelicula", detalles: error.message });
  }
});

// POST /pelicula
router.post("/", async function (req, res) {
  try {
    const nuevopelicula = await peliculaService.post(
      req.body.id,
      req.body.titulo,
      req.body.anio,
      req.body.genero,
      req.body.valoracion,
      req.body.plataforma,
      req.body.img,
    );
    res.status(201).json(nuevopelicula);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el pelicula" });
  }
});

// DELETE /pelicula/:id
router.delete("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const peliculaEliminado = await peliculaService.getById(id);

    if (!peliculaEliminado) {
      return res.status(404).json({ error: "pelicula no encontrado" });
    }

    const eliminado = await peliculaService.deleteById(id);

    if (eliminado) {
      res.json({ mensaje: "pelicula eliminado", pelicula: peliculaEliminado });
    } else {
      res.status(404).json({ error: "pelicula no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el pelicula" });
  }
});
// PUT /pelicula/:id
router.put("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const peliculaExistente = await peliculaService.getById(id);

    if (!peliculaExistente) {
      return res.status(404).json({ error: "pelicula no encontrado" });
    }

    const updatedFields = {
      titulo: req.body.titulo ?? peliculaExistente.titulo,
      anio: req.body.anio ?? peliculaExistente.anio,
      genero: req.body.genero ?? peliculaExistente.genero,
      valoracion: req.body.valoracion ?? peliculaExistente.valoracion,
      plataforma: req.body.plataforma ?? peliculaExistente.plataforma,
      img: req.body.img ?? peliculaExistente.img,
    };

    const peliculaActualizada = await peliculaService.put(id, updatedFields);
    res.json(peliculaActualizada);
  } catch (error) {
    res
      .status(500)
      .json({
        error: "Error al actualizar el pelicula",
        detalles: error.message,
      });
  }
});

module.exports = router;

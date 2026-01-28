let coche = require("../models/cocheModels");
let cocheService = require("../service/coche-services");

var express = require("express");
var router = express.Router();

// GET /coche
router.get("/", async function (req, res) {
  try {
    const coche = await cocheService.get();
    res.status(200).json(coche);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los coches" });
  }
});

router.get("/:marca", async function (req, res) {
  try {
    const marca = req.params.marca;
    console.log("Buscando:", marca);
    const coche = await cocheService.getByName(marca);
    console.log("Resultado:", coche);

    if (!coche) {
      return res.status(404).json({ error: "coche no encontrado" });
    }

    res.json(coche);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el coche", detalles: error.message });
  }
});

// POST /coche
router.post("/", async function (req, res) {
  try {
    const nuevocoche = await cocheService.post(
      req.body.marca,
      req.body.modelo,
      req.body.img,
    );
    res.status(201).json(nuevocoche);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el coche" });
  }
});

// PUT /coche/:marca
router.put("/:marca", async function (req, res) {
  try {
    const marca = req.params.marca;
    const actualizado = await cocheService.update(
      marca,
      req.body.modelo,
      req.body.img,
    );

    if (actualizado) {
      const cocheActualizado = await cocheService.getByName(marca);
      res.json({ mensaje: "coche actualizado", coche: cocheActualizado });
    } else {
      res.status(404).json({ error: "coche no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al actualizar el coche" });
  }
});

// DELETE /coche/:marca
router.delete("/:marca", async function (req, res) {
  try {
    const marca = req.params.marca;
    const cocheEliminado = await cocheService.getByName(marca);

    if (!cocheEliminado) {
      return res.status(404).json({ error: "coche no encontrado" });
    }

    const eliminado = await cocheService.delete(marca);

    if (eliminado) {
      res.json({ mensaje: "coche eliminado", coche: cocheEliminado });
    } else {
      res.status(404).json({ error: "coche no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el coche" });
  }
});

module.exports = router;

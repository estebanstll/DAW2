let hospital = require("../models/pacienteModel");
let hospitalService = require("../service/hospital-services");

var express = require("express");
var router = express.Router();

// GET /hospital
router.get("/", async function (req, res) {
  try {
    const hospital = await hospitalService.get();
    res.status(201).json(hospital);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los hospitals" });
  }
});

router.get("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    console.log("Buscando:", nombre);
    const hospital = await hospitalService.getByName(nombre);
    console.log("Resultado:", hospital);

    if (!hospital) {
      return res.status(404).json({ error: "hospital no encontrado" });
    }

    res.json(hospital);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el hospital", detalles: error.message });
  }
});

// POST /hospital
router.post("/", async function (req, res) {
  try {
    const nuevohospital = await hospitalService.post(
      req.body.nombre,
      req.body.gravedad,
    );
    res.status(201).json(nuevohospital);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el hospital" });
  }
});

// PUT /hospital/:nombre
router.put("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const actualizado = await hospitalService.update(nombre, req.body.gravedad);

    if (actualizado) {
      const hospitalActualizado = await hospitalService.getByName(nombre);
      res.json({
        mensaje: "hospital actualizado",
        hospital: hospitalActualizado,
      });
    } else {
      res.status(404).json({ error: "hospital no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al actualizar el hospital" });
  }
});

// DELETE /hospital/:nombre
router.delete("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const hospitalEliminado = await hospitalService.getByName(nombre);

    if (!hospitalEliminado) {
      return res.status(404).json({ error: "hospital no encontrado" });
    }

    const eliminado = await hospitalService.delete(nombre);

    if (eliminado) {
      res.json({ mensaje: "hospital eliminado", hospital: hospitalEliminado });
    } else {
      res.status(404).json({ error: "hospital no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el hospital" });
  }
});

module.exports = router;

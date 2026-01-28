let hospital = require("../models/pacienteModel");
let hospitalService = require("../service/paciente-services");

var express = require("express");
var router = express.Router();

// GET /hospital
router.get("/", async function (req, res) {
  try {
    const pacientes = await hospitalService.get();
    res.status(201).json(pacientes);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los pacientes" });
  }
});

router.get("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    console.log("Buscando:", nombre);
    const paciente = await hospitalService.getByName(nombre);
    console.log("Resultado:", paciente);

    if (!paciente) {
      return res.status(404).json({ error: "paciente no encontrado" });
    }

    res.json(paciente);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el paciente", detalles: error.message });
  }
});

// POST /hospital
router.post("/", async function (req, res) {
  try {
    const nuevoPaciente = await hospitalService.post(
      req.body.nombre,
      req.body.gravedad,
    );
    res.status(201).json(nuevoPaciente);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el paciente" });
  }
});

// PUT /hospital/:nombre
router.put("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const actualizado = await hospitalService.update(nombre, req.body.gravedad);

    if (actualizado) {
      const pacienteActualizado = await hospitalService.getByName(nombre);
      res.json({
        mensaje: "paciente actualizado",
        paciente: pacienteActualizado,
      });
    } else {
      res.status(404).json({ error: "paciente no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al actualizar el paciente" });
  }
});

// DELETE /hospital/:nombre
router.delete("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    const pacienteEliminado = await hospitalService.getByName(nombre);

    if (!pacienteEliminado) {
      return res.status(404).json({ error: "paciente no encontrado" });
    }

    const eliminado = await hospitalService.delete(nombre);

    if (eliminado) {
      res.json({ mensaje: "paciente eliminado", paciente: pacienteEliminado });
    } else {
      res.status(404).json({ error: "paciente no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el paciente" });
  }
});

module.exports = router;

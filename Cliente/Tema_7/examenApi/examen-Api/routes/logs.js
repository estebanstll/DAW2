let log = require("../models/logsModel");
let logService = require("../service/log-services");

var express = require("express");
var router = express.Router();

// GET /log
router.get("/", async function (req, res) {
  try {
    const loges = await logService.get();
    res.status(201).json(loges);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los loges" });
  }
});

router.get("/:fecha", async function (req, res) {
  try {
    const fecha = req.params.fecha;
    console.log("Buscando:", fecha);
    const log = await logService.getByDate(fecha);
    console.log("Resultado:", log);

    if (!log) {
      return res.status(404).json({ error: "log no encontrado" });
    }

    res.json(log);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el log", detalles: error.message });
  }
});

// POST /log
router.post("/", async function (req, res) {
  try {
    const nuevolog = await logService.post(
      req.body.mensaje,
      req.body.nivel,
      req.body.fecha,
    );
    res.status(201).json(nuevolog);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el log" });
  }
});

module.exports = router;

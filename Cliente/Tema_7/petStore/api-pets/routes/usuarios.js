let Usuario = require("../models/usuarioModel");
let usuarioService = require("../service/usuario-services");

var express = require("express");
var router = express.Router();

router.get("/:nombre", async function (req, res) {
  try {
    const nombre = req.params.nombre;
    console.log("Buscando:", nombre);
    const usuario = await usuarioService.getByName(nombre);
    console.log("Resultado:", usuario);

    if (!usuario) {
      return res.status(404).json({ error: "usuario no encontrado" });
    }

    res.json(usuario);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el usuario", detalles: error.message });
  }
});

router.post("/", async function (req, res) {
  try {
    const Usuario = await usuarioService.post(
      req.body.nombre,
      req.body.contrasena,
    );
    res.status(201).json(Usuario);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el usuario" });
  }
});

module.exports = router;

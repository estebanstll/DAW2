let producto = require("../models/productosModel");
let productoService = require("../service/products-service");

var express = require("express");
var router = express.Router();

// GET /producto
router.get("/", async function (req, res) {
  try {
    const productoes = await productoService.get();
    res.status(201).json(productoes);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los productoes" });
  }
});

router.get("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    console.log("Buscando:", id);
    const producto = await productoService.getById(id);
    console.log("Resultado:", producto);

    if (!producto) {
      return res.status(404).json({ error: "producto no encontrado" });
    }

    res.json(producto);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el producto", detalles: error.message });
  }
});

// POST /producto
router.post("/", async function (req, res) {
  try {
    const nuevoproducto = await productoService.post(
      req.body.id,
      req.body.name,
      req.body.description,
      req.body.price,
      req.body.user,
    );
    res.status(201).json(nuevoproducto);
  } catch (error) {
    res.status(500).json({ error: "Error al crear el producto" });
  }
});

// DELETE /producto/:id
router.delete("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const productoEliminado = await productoService.getById(id);

    if (!productoEliminado) {
      return res.status(404).json({ error: "producto no encontrado" });
    }

    const eliminado = await productoService.deleteById(id);

    if (eliminado) {
      res.json({ mensaje: "producto eliminado", producto: productoEliminado });
    } else {
      res.status(404).json({ error: "producto no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el producto" });
  }
});

module.exports = router;

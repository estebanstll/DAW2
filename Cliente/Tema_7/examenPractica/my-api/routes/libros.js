let Libro = require("../modules/libro.js");
var express = require("express");
var router = express.Router();

const libros = [];

/* GET users listing. */
router.get("/", function (req, res, next) {
  res.json(libros);
});

router.post("/", function (req, res) {
  let libro = new Libro(req.body.titulo, req.body.autor, req.body.anio);

  libros.push(libro);
  res.status(201).json(libro);
});

module.exports = router;

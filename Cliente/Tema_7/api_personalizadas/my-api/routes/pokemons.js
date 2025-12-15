var express = require("express");
var router = express.Router();

const pokemons = [];

// GET todos
router.get("/", function (req, res) {
  res.json(pokemons);
});

// GET por nombre
router.get("/:name", function (req, res) {
  const pokemon = pokemons.find((p) => p.name === req.params.name);

  if (!pokemon) {
    return res.status(404).json({ error: "Pokemon no encontrado" });
  }

  res.json(pokemon);
});

// POST crear
router.post("/", function (req, res) {
  const newPokemon = {
    name: req.body.name,
    type: req.body.type,
  };

  pokemons.push(newPokemon);
  res.status(201).json(newPokemon);
});

// PUT actualizar por nombre
router.put("/:name", function (req, res) {
  const pokemon = pokemons.find((p) => p.name === req.params.name);

  if (!pokemon) {
    return res.status(404).json({ error: "Pokemon no encontrado" });
  }

  pokemon.name = req.body.name ?? pokemon.name;
  pokemon.type = req.body.type ?? pokemon.type;

  res.json(pokemon);
});

// DELETE por nombre
router.delete("/:name", function (req, res) {
  const index = pokemons.findIndex((p) => p.name === req.params.name);

  if (index === -1) {
    return res.status(404).json({ error: "Pokemon no encontrado" });
  }

  const deleted = pokemons.splice(index, 1);
  res.json(deleted[0]);
});

module.exports = router;

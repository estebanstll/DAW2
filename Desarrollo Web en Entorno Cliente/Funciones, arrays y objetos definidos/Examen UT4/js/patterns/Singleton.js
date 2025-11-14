import { Pokemon } from "./models/pokemon.js";

function crearPokemon(n, t, a) {
  const nuevoPokemon = new Pokemon({
    id: Date.now(),
    nombre: n,
    tipo: t,
    nivel: a,
  });

  return nuevoPokemon;
}
// la verdad es que esto esta mal, ni idea de como se hacia

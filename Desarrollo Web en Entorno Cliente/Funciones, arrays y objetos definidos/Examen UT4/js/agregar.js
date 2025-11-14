import { Pokemon } from "./models/pokemon.js";

document.addEventListener("DOMContentLoaded", () => {
  const nombre = document.getElementById("nombre");
  const tipo = document.getElementById("tipo");
  const nivel = document.getElementById("nivel");
  const mensaje = document.getElementById("mensaje");
  const btnGuardar = document.getElementById("guardar");

  if (!localStorage.getItem("pokemons")) {
    localStorage.setItem("pokemons", JSON.stringify([]));
  }

  function obtenerPokemons() {
    return JSON.parse(localStorage.getItem("pokemons")) || [];
  }

  function guardarPokemons(arr) {
    localStorage.setItem("pokemons", JSON.stringify(arr));
  }

  btnGuardar.addEventListener("click", () => {
    const n = nombre.value.trim();
    const t = tipo.value;
    const a = parseInt(nivel.value);

    if (!n || isNaN(a)) {
      mensaje.textContent =
        "Por favor completa todos los campos correctamente.";
      return;
    }

    const arr = obtenerPokemons();
    const nuevoPokemon = new Pokemon({
      id: Date.now(),
      nombre: n,
      tipo: t,
      nivel: a,
    });

    arr.push(nuevoPokemon);
    guardarPokemons(arr);

    mensaje.textContent = `Pokémon ${n} (${t}) agregado correctamente.`;

    nombre.value = "";
    nivel.value = "";
  });
});

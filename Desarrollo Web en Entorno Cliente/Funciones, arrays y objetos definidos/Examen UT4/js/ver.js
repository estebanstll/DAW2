import { Pokemon } from "./models/pokemon.js";

const STORAGE_KEY = "pokemons";

function obtenerPokemons() {
  const raw = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  return raw.map((p) => new Pokemon(p));
}

const filtroInput = document.getElementById("filtroTexto");
const lista = document.getElementById("lista");
const btnFiltrar = document.getElementById("aplicarFiltro");
const eliminar = document.getElementById("Borrar");

function renderPokemons() {
  const textoFiltro = filtroInput.value.trim().toLowerCase();
  const pokemons = obtenerPokemons();

  const filtrados = pokemons.filter(
    (p) => !p.eliminado && p.nombre.toLowerCase().includes(textoFiltro)
  );

  if (!filtrados.length) {
    lista.innerHTML = "<p>No hay Pokémon que coincidan con el filtro.</p>";
    return;
  }

  lista.innerHTML = filtrados
    .map(
      (p) => `
      <div style="border:1px solid #999;padding:8px;margin:5px;">
        <strong>${p.nombre}</strong> (${p.tipo})<br>
        Nivel: ${p.nivel} <br>
        Capturado: ${p.id}<br>
      </div>
    `
    )
    .join("");
}

btnFiltrar.addEventListener("click", renderPokemons);

eliminar.addEventListener("click", (e) => {
  localStorage.setItem(STORAGE_KEY, JSON.stringify([]));
  renderPokemons();
});

renderPokemons();

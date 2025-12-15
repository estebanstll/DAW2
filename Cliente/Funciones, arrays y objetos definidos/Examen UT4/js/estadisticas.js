const STORAGE_KEY = "pokemons";

function obtenerPokemons() {
  return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
}

function calcularEstadisticas(pokemons) {
  const stats = {};

  pokemons.forEach((p) => {
    if (p.eliminado) return;
    const t = p.tipo.toLowerCase();

    if (!stats[t]) stats[t] = { count: 0, sumNivel: 0 };
    stats[t].count++;
    stats[t].sumNivel += p.nivel;
  });

  return Object.entries(stats).map(([tipo, data]) => ({
    tipo,
    nivelPromedio: (data.sumNivel / data.count || 0).toFixed(1),
  }));
}

function renderEstadisticas() {
  const contenedor = document.getElementById("estadisticas");
  const pokemons = obtenerPokemons();
  const stats = calcularEstadisticas(pokemons);

  if (stats.length === 0) {
    contenedor.innerHTML = "<p>No hay Pokémon activos.</p>";
    return;
  }

  contenedor.innerHTML = stats
    .map(
      ({ tipo, nivelPromedio }) => `
        <div class="tipo">
          <p><strong>${
            tipo.charAt(0).toUpperCase() + tipo.slice(1)
          }: </strong>Nivel promedio: ${nivelPromedio}</p>
        </div>
      `
    )
    .join("");
}

window.addEventListener("storage", renderEstadisticas);

renderEstadisticas();

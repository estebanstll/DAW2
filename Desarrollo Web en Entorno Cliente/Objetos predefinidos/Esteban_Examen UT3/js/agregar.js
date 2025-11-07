const nombre = document.getElementById("nombre");
const tipo = document.getElementById("tipo");
const velocidad = document.getElementById("velocidad");

const mensaje = document.getElementById("mensaje");
const btnGuardar = document.getElementById("guardar");

// Inicializar si no existe
if (!localStorage.getItem("trenes")) {
  localStorage.setItem("trenes", JSON.stringify([]));
}

function obtenertrenes() {
  return JSON.parse(localStorage.getItem("trenes")) || [];
}

function guardartrenes(arr) {
  localStorage.setItem("trenes", JSON.stringify(arr));
}

btnGuardar.addEventListener("click", (e) => {
  e.preventDefault();
  const n = nombre.value.trim();
  const t = tipo.value;
  const a = parseInt(velocidad.value);

  if (!n || isNaN(a)) {
    mensaje.textContent = "Por favor completa todos los campos correctamente.";
    return;
  }

  const arr = obtenertrenes();
  const nuevoTren = {
    id: Date.now(),
    nombre: n,
    tipo: t,
    velocidad: a,
  };

  arr.push(nuevoTren);
  guardartrenes(arr);

  mensaje.textContent = `tren ${n} (${t}) agregado correctamente.`;

  nombre.value = "";
  velocidad.value = "";
});

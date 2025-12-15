const btn = document.getElementById("enviar");
const nombre = document.getElementById("nombre");
const cookie = document.getElementById("cookie");
const btnEliminar = document.getElementById("eliminar");

btn.addEventListener("click", (e) => {
  e.preventDefault();

  document.cookie = `nombre=${nombre.value}`;
  location.reload();
});

btnEliminar.addEventListener("click", (e) => {
  e.preventDefault();

  document.cookie = "nombre=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
  location.reload();
});

if (document.cookie !== "") {
  cookie.textContent = document.cookie;
} else {
  cookie.textContent = "No hay ningún nombre almacenado";
}

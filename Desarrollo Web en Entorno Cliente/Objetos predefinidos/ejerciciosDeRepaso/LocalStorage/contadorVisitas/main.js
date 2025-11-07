document.addEventListener("DOMContentLoaded", () => {
  const contador = document.getElementById("Contador");

  // Si no existe todavía el contador en localStorage, lo inicializamos en 0
  if (localStorage.getItem("numero") === null) {
    localStorage.setItem("numero", 0);
  }

  // Obtenemos el valor actual y lo convertimos a número
  let cont = Number(localStorage.getItem("numero"));

  // Incrementamos en 1
  cont++;

  // Guardamos el nuevo valor
  localStorage.setItem("numero", cont);

  // Mostramos el resultado
  contador.textContent = "Número de visitas: " + cont;
});

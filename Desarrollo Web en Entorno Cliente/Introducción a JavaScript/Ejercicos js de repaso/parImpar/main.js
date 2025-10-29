const btn = document.getElementById("envio");
const input = document.getElementById("in");
const output = document.getElementById("out");

btn.addEventListener("click", (e) => {
  e.preventDefault();
  const valor = parseInt(input.value);

  if (isNaN(valor)) {
    output.textContent = "Introduce un numero";
  } else if (valor % 2 === 0) {
    output.textContent = "Es par";
  } else {
    output.textContent = "Es impar";
  }
});

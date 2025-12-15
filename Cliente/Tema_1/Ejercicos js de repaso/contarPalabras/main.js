const btn = document.getElementById("envio");
const input = document.getElementById("in");
const output = document.getElementById("out");

btn.addEventListener("click", (e) => {
  output.textContent = "fdka";
  e.preventDefault();
  let frase = input.value;
  const arrayPalabra = frase.split(" ");

  output.textContent =
    "La frase tiene un total de " + arrayPalabra.length + " palabras";
});

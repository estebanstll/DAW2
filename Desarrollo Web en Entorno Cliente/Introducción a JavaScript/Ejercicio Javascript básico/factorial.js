const numeroIntroducido = document.getElementById("factorial");
const boton = document.getElementById("calcular");
const output = document.getElementById("resultado");

boton.addEventListener("click", (e) => {
  e.preventDefault();
  if (parseInt(numeroIntroducido.value) > 0) {
    let resultado = 1;

    for (let index = parseInt(numeroIntroducido.value); index > 0; index--) {
      resultado = resultado * index;
    }
    output.textContent = `El factorial de ${numeroIntroducido.value} es ${resultado}`;
    output.style.color = "green";
  } else {
    output.textContent = "introduce un numero permitido";
    output.style.color = "red";
    numeroIntroducido.textContent = "";
  }
});

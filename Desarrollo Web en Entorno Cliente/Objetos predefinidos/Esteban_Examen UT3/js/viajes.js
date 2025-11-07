const inicio = document.getElementById("inicio");
const fin = document.getElementById("fin");
const output = document.getElementById("output");
const btn = document.getElementById("comprobar");
//Sodor Central, Knapford, Vicarstown y Tidmouth Sheds

btn.addEventListener("click", (e) => {
  e.preventDefault();
  if (inicio.value === fin.value) {
    output.textContent = "mismo destino";
  } else {
    if (inicio.value === "Sodor Central") {
      if (fin.value === "Knapford") {
        output.textContent = "Viaje de Sodor a knapford || Kilometros:25";
      }
      if (fin.value === "Vicarstown") {
        output.textContent = "Viaje de Sodor a Vicarstown || Kilometros:35";
      }
      if (fin.value === "Tidmouth Sheds") {
        output.textContent = "Viaje de Sodor a Tidmouth Sheds || Kilometros:47";
      }
    }
    if (inicio.value === "Knapford") {
      if (fin.value === "Sodor Central") {
        output.textContent =
          "Viaje de Knapford a Sodor Central || Kilometros:25";
      }
      if (fin.value === "Vicarstown") {
        output.textContent = "Viaje de Knapford a Vicarstown || Kilometros:10";
      }
      if (fin.value === "Tidmouth Sheds") {
        output.textContent =
          "Viaje de Knapford a Tidmouth Sheds || Kilometros:82";
      }
    }

    if (inicio.value === "Vicarstown") {
      if (fin.value === "Sodor Central") {
        output.textContent =
          "Viaje de Vicarstown a Sodor Central || Kilometros:35";
      }
      if (fin.value === "Knapford") {
        output.textContent = "Viaje de Vicarstown a Knapford || Kilometros:10";
      }
      if (fin.value === "Tidmouth Sheds") {
        output.textContent =
          "Viaje de Vicarstown a Tidmouth Sheds || Kilometros:12";
      }
    }

    if (inicio.value === "Tidmouth Sheds") {
      if (fin.value === "Sodor Central") {
        output.textContent = "Viaje de Tidmouth Sheds a Sodor || Kilometros:47";
      }
      if (fin.value === "Knapford") {
        output.textContent =
          "Viaje de Tidmouth Sheds a Knapford || Kilometros:82";
      }
      if (fin.value === "Vicarstown") {
        output.textContent =
          "Viaje de Tidmouth Sheds a Vicarstown || Kilometros:12";
      }
    }
  }
});
//Para hacer el evento aleatorio deberia de usar la funcion math, le pongo valores del 1 al 100 y si uno de esos valores coincide con el 21 activo un evento aleatorio

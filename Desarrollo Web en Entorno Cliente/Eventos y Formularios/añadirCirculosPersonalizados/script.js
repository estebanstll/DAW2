const form = document.getElementById("form");
const nombre = document.getElementById("nombre");
const categoria = document.getElementById("categoria");
const color = document.getElementById("color");
const lista = document.getElementById("lista");
const filtro = document.getElementById("filtro");

// ------------ CARGAR DE LOCALSTORAGE ---------------------
function obtenerDatos() {
  return JSON.parse(localStorage.getItem("objetos")) || [];
}

function guardarDatos(arr) {
  localStorage.setItem("objetos", JSON.stringify(arr));
}

// ------------ MOSTRAR CÍRCULOS -------------------------
function mostrar() {
  lista.innerHTML = "";

  let datos = obtenerDatos();

  if (filtro.value !== "todos") {
    datos = datos.filter((x) => x.categoria === filtro.value);
  }

  datos.forEach((obj, index) => {
    const div = document.createElement("div");
    div.className = "circulo";
    div.style.background = obj.color;
    div.textContent = obj.categoria;

    div.addEventListener("click", () => {
      eliminar(index);
    });

    lista.appendChild(div);
  });
}

// ------------ ELIMINAR -------------------------
function eliminar(i) {
  let datos = obtenerDatos();
  datos.splice(i, 1);
  guardarDatos(datos);
  mostrar();
}

// ------------ FORMULARIO SUBMIT -------------------------
form.addEventListener("submit", function (e) {
  e.preventDefault();

  if (!form.checkValidity()) {
    alert("Revisa los campos");
    return;
  }

  const nuevo = {
    nombre: nombre.value,
    categoria: categoria.value,
    color: color.value,
  };

  const datos = obtenerDatos();
  datos.push(nuevo);

  guardarDatos(datos);
  mostrar();

  form.reset();
});

// ------------ FILTRO -------------------------
filtro.addEventListener("change", mostrar);

// Al cargar la página:
mostrar();

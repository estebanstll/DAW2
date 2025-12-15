const existingUser = localStorage.getItem("user");
const existingPass = localStorage.getItem("password");

const title = document.getElementById("title");
const btn = document.getElementById("btn");
const form = document.getElementById("form");
const maxPuntuacion = document.getElementById("best");

//comprobaciones localStorage
if (!existingUser || !existingPass) {
  //si no existe el localstorage entrara aqui
  title.textContent = "Registro inicial";
  btn.textContent = "Registrarse";
  btn.classList.add("h2");

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const user = document.getElementById("user").value;
    const pass = document.getElementById("password").value;

    localStorage.setItem("user", user);
    localStorage.setItem("password", pass);

    location.reload(); //recarga la ventana y entonces pasa al login porque ya esta creada la contraseña y el usuario
  });
} else {
  //si existe entra aqui
  title.textContent = "Iniciar sesión";
  btn.textContent = "Entrar";

  form.addEventListener("submit", (e) => {
    e.preventDefault();
    //sacar datos del localStorage
    const user = document.getElementById("user").value;
    const pass = document.getElementById("password").value;

    //comprobar los datos del input con los del localStorage
    if (user === existingUser && pass === existingPass) {
      window.location.href = "juego.html";
    } else {
      document
        .getElementById("password")
        .setCustomValidity("Credenciales incorrectas");
      document.getElementById("password").reportValidity();

      document.getElementById("password").addEventListener("input", () => {
        document.getElementById("password").setCustomValidity("");
      });
    }
  });
}

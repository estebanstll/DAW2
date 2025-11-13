// ✅ Intercepta el acceso a un objeto (seguridad, validación, logs...)
const usuario = { nombre: "Rick", rol: "user" };

const proxy = new Proxy(usuario, {
  get(t, p) {
    console.log(`Accediendo a ${p}`);
    return t[p];
  },
  set(t, p, v) {
    if (p === "rol" && v === "admin") throw Error("Prohibido");
    t[p] = v;
    return true;
  },
});

proxy.nombre; // Accediendo a nombre
proxy.rol = "admin"; // ❌ Error

// 💬 Se usa para controlar el acceso o añadir reglas
// sin modificar directamente el objeto original.

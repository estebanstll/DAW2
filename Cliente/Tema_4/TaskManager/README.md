# TaskManager – JavaScript + LocalStorage

Gestor de tareas modular sin backend. Utiliza LocalStorage para almacenar datos y aplica varios patrones de diseño como Factory, CRUD modular, Observer (opcional) y el Modular Pattern para organizar la arquitectura del proyecto.

---

## Estructura del proyecto

```
TaskManager/
│
├── index.html
├── main.css
├── main.js
│
└── js/
    ├── tasks/
    │     └── task.js
    │
    ├── patterns/
    │     ├── CRUD.js
    │     ├── Factory.js
    │     └── observer.js
    │
    └── models/
          └── task.js
```

---

## Patrones de diseño utilizados

Este proyecto implementa varios patrones de diseño para mantener una arquitectura limpia, modular y extensible.

### 1. Factory Pattern (Fábrica)

Se utiliza para crear tareas de manera controlada y consistente.  
La clase `TaskFactory` encapsula la creación de objetos `Task`, garantizando:

- Validación del título
- id único con `Date.now()`
- prioridad por defecto
- fecha de creación automática

Permite desacoplar la creación del objeto del resto de la lógica:

```js
const task = TaskFactory.create({ title, description, priority });
```

---

### 2. CRUD Pattern (Create, Read, Update, Delete)

Aunque no es un patron como tal, separa la lógica relacionada con persistencia.  
El archivo `CRUD.js` maneja TODA la interacción con LocalStorage:

- `createTask()`
- `readTask()`
- `updateTask()`
- `deleteTask()`
- `getAllTasks()`

Esto evita mezclar la lógica de almacenamiento con la interfaz o la lógica de negocio.

---

### 3. Observer Pattern (Opcional)

En proceso de implementarlo

---

### 4. Modular Pattern (Arquitectura del proyecto)

Todo el proyecto está organizado en módulos ES6, cada uno con responsabilidades claras:

- `models/` → definición de datos
- `patterns/` → lógica estructural (CRUD, Factory, Observer)
- `tasks/` → posibles extensiones relacionadas con tareas
- `main.js` → lógica de interfaz (UI Controller)

---

## Descripción general del proyecto

El sistema permite:

- Crear tareas con título, descripción, prioridad y estado.
- Guardar y recuperar tareas desde LocalStorage.
- Filtrar por prioridad.
- Filtrar por estado (pendientes o completadas).
- Marcar tareas como hechas.
- Eliminar tareas individuales.
- Renderizar dinámicamente la lista de tareas.
- Mantener una arquitectura clara basada en módulos y patrones.

---

## Módulos principales

### models/task.js

Define la clase `Task`, encargada de representar cada tarea.

Propiedades:

- id
- title
- description
- priority
- done
- createdAt

Métodos:

- `isDone()`
- `toggleDone()`

---

### patterns/Factory.js

Genera nuevas tareas de manera segura y controlada.

Ejemplo:

```js
TaskFactory.create({ title, description, priority });
```

---

### patterns/CRUD.js

Gestiona la persistencia en LocalStorage.  
Expone funciones para crear, leer, actualizar y eliminar tareas, así como para inicializar o limpiar el almacenamiento.

---

## Interfaz – main.js

`main.js` es el encargado de:

- Gestionar el formulario.
- Crear tareas usando Factory.
- Guardarlas con CRUD.
- Renderizar toda la lista mediante `renderTasks()`.
- Aplicar filtros.
- Escuchar eventos de click para marcar como hechas o eliminar.

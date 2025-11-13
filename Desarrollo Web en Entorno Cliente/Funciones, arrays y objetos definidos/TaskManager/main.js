import * as CRUD from "./js/patterns/CRUD.js";
import { Task } from "./js/models/task.js";
import { TaskFactory } from "./js/patterns/Factory.js";

// Referencias a elementos del DOM
const taskForm = document.getElementById("task-form");
const taskTitle = document.getElementById("task-title");
const taskDesc = document.getElementById("task-desc");
const taskPriority = document.getElementById("task-priority");
const taskList = document.getElementById("task-list");
const filterPriority = document.getElementById("filter-priority");
const filterStatus = document.getElementById("filter-status");

let filteredByPriority = "all";
let filteredByStatus = "all";

function filterByPriority(tasks, priority) {
  if (priority === "all") return tasks;
  return tasks.filter((t) => t.priority === priority);
}

function filterByStatus(tasks, status) {
  if (status === "all") return tasks;
  if (status === "done") return tasks.filter((t) => t.done === true);
  if (status === "pending") return tasks.filter((t) => t.done === false);
  return tasks;
}

function renderTasks() {
  let tasks = CRUD.getAllTasks();

  // Aplica filtros
  tasks = filterByPriority(tasks, filteredByPriority);
  tasks = filterByStatus(tasks, filteredByStatus);

  taskList.innerHTML = "";

  tasks.forEach((task) => {
    const li = document.createElement("li");
    li.className = "task-item";
    li.dataset.id = task.id;

    li.innerHTML = `
      <input type="checkbox" class="task-done" ${task.done ? "checked" : ""}>
      <span class="task-title ${task.done ? "done" : ""}">${task.title}</span>
      <span class="task-priority">[${task.priority}]</span>
      <button class="delete-task">Eliminar</button>
    `;

    taskList.appendChild(li);
  });
}

// Eventos para actualizar filtros y renderizar
filterPriority.addEventListener("change", (e) => {
  filteredByPriority = e.target.value;
  renderTasks();
});

filterStatus.addEventListener("change", (e) => {
  filteredByStatus = e.target.value;
  renderTasks();
});

// Formulario y lista sin cambios
taskForm.addEventListener("submit", (e) => {
  e.preventDefault();

  const title = taskTitle.value.trim();
  const description = taskDesc.value.trim();
  const priority = taskPriority.value;

  if (!title) return;

  const newTask = TaskFactory.create({ title, description, priority });

  CRUD.createTask(newTask);
  renderTasks();
  taskForm.reset();
});

taskList.addEventListener("click", (e) => {
  const li = e.target.closest("li");
  if (!li) return;

  const taskId = Number(li.dataset.id);
  const task = CRUD.readTask(taskId);

  if (e.target.classList.contains("task-done")) {
    task.done = e.target.checked;
    CRUD.updateTask(task);
    renderTasks();
  }

  if (e.target.classList.contains("delete-task")) {
    CRUD.deleteTask(taskId);
    renderTasks();
  }
});

// Render inicial
renderTasks();

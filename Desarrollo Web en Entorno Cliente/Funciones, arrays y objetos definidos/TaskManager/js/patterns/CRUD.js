import { Task } from "../models/task.js";

const STORAGE_KEY = "tasks";

/**
 * Inicializa el almacenamiento local si no existe.
 * Crea una clave vacía en localStorage.
 */
export function initStorage() {
  if (!localStorage.getItem(STORAGE_KEY)) {
    localStorage.setItem(STORAGE_KEY, JSON.stringify([]));
  }
}

// Llamar a la inicialización automáticamente al cargar el módulo

/**
 * Obtiene todas las tareas almacenadas en localStorage.
 * @returns {Task[]}
 */
export function getAllTasks() {
  const data = JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
  return data.map(
    (t) =>
      new Task(
        t.id,
        t.title,
        t.description,
        t.priority,
        t.done,
        new Date(t.createdAt)
      )
  );
}

/**
 * Guarda un array completo de tareas en localStorage.
 * @param {Task[]} tasks
 */
export function saveAllTasks(tasks) {
  initStorage();

  localStorage.setItem(STORAGE_KEY, JSON.stringify(tasks));
}

/**
 * Crea (agrega) una nueva tarea en localStorage.
 * @param {Task} task
 */
export function createTask(task) {
  const tasks = getAllTasks();
  tasks.push(task);
  saveAllTasks(tasks);
}

/**
 * Lee (obtiene) una tarea específica por su id.
 * @param {number} id
 * @returns {Task | undefined}
 */
export function readTask(id) {
  return getAllTasks().find((t) => t.id === id);
}

/**
 * Actualiza una tarea existente (por id).
 * @param {Task} updatedTask
 */
export function updateTask(updatedTask) {
  const tasks = getAllTasks();
  const index = tasks.findIndex((t) => t.id === updatedTask.id);
  if (index !== -1) {
    tasks[index] = updatedTask;
    saveAllTasks(tasks);
  }
}

/**
 * Elimina una tarea por su id.
 * @param {number} id
 */
export function deleteTask(id) {
  const tasks = getAllTasks().filter((t) => t.id !== id);
  saveAllTasks(tasks);
}

/**
 * Elimina todas las tareas del almacenamiento.
 */
export function deleteAllTasks() {
  localStorage.setItem(STORAGE_KEY, JSON.stringify([]));
}

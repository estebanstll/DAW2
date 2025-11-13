import { Task } from "../models/task";

export class TaskFactory {
  static create({ title, description, priority }) {
    if (!title) throw new Error("El título es obligatorio");
    return new Task(
      Date.now(),
      title,
      description,
      priority || "normal",
      false,
      new Date()
    );
  }
}

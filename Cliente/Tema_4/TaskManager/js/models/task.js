export class Task {
  constructor(
    id,
    title,
    description,
    priority = "normal",
    done = false,
    createdAt = new Date()
  ) {
    this.id = id;
    this.title = title;
    this.description = description;
    this.priority = priority;
    this.done = done;
    this.createdAt = createdAt;
  }

  isDone() {
    return this.done;
  }

  toggleDone() {
    this.done = !this.done;
  }
}

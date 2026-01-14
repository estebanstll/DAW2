var express = require("express");
var router = express.Router();

let TaskService = require("../service/task-services");

router.get("/:id", async (req, res) => {
  try {
    const task = await TaskService.getById(req.params.id);
    if (!task) {
      res.status(404).send("Not Found");
    } else {
      res.json(task);
    }
  } catch (error) {
    res.status(500).send(error.message);
  }
});

router.get("/", async function (req, res, next) {
  try {
    const task = await TaskService.get();
    res.json(task);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

router.post("/", async function (req, res, next) {
  try {
    const task = await TaskService.post(
      req.body.titulo,
      req.body.autor,
      req.body.anio
    );
    res.status(201).json(task);
  } catch (error) {
    res.status(500).send(error.message);
  }
});

router.delete("/:id", async (req, res) => {
  try {
    const deleted = await TaskService.delete(req.params.id);
    if (!deleted) {
      res.status(404).send("Not Found");
    } else {
      res.send(true);
    }
  } catch (error) {
    res.status(500).send(error.message);
  }
});

router.put("/:id", async (req, res) => {
  try {
    const updated = await TaskService.update(
      req.params.id,
      req.body.titulo,
      req.body.autor,
      req.body.anio
    );
    if (!updated) {
      res.status(404).send("Not Found");
    } else {
      const task = await TaskService.getById(req.params.id);
      res.json(task);
    }
  } catch (error) {
    res.status(500).send(error.message);
  }
});

module.exports = router;

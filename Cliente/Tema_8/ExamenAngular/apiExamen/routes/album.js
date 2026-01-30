let Album = require("../models/albumModel");
const AlbumService = require("../service/album-service");
const CancionService = require("../service/cancion-service");

var express = require("express");
var router = express.Router();

// GET /albums
router.get("/", async function (req, res) {
  try {
    const albums = await AlbumService.get();
    res.status(200).json(albums);
  } catch (error) {
    res.status(500).json({ error: "Error al obtener los albumes" });
  }
});

// GET /albums/:id
router.get("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    console.log("Buscando album:", id);
    const album = await AlbumService.getById(id);
    console.log("Resultado:", album);

    if (!album) {
      return res.status(404).json({ error: "Album no encontrado" });
    }

    res.json(album);
  } catch (error) {
    console.error("Error en GET:", error);
    res
      .status(500)
      .json({ error: "Error al obtener el album", detalles: error.message });
  }
});

// GET /albums/:id/songs - Obtener canciones de un album
router.get("/:id/songs", async function (req, res) {
  try {
    const albumId = req.params.id;
    console.log("Buscando canciones del album:", albumId);

    const album = await AlbumService.getById(albumId);
    if (!album) {
      return res.status(404).json({ error: "Album no encontrado" });
    }

    const canciones = await CancionService.getByAlbumId(albumId);
    res.json(canciones);
  } catch (error) {
    console.error("Error en GET /songs:", error);
    res.status(500).json({
      error: "Error al obtener las canciones",
      detalles: error.message,
    });
  }
});

// POST /albums
router.post("/", async function (req, res) {
  try {
    const nuevoAlbum = await AlbumService.post(
      req.body.titulo,
      req.body.artista,
      req.body.anio,
      req.body.genero,
      req.body.img,
    );
    res.status(201).json(nuevoAlbum);
  } catch (error) {
    console.error("Error en POST album:", error);
    res
      .status(500)
      .json({ error: "Error al crear el album", detalles: error.message });
  }
});

// DELETE /albums/:id
router.delete("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const albumEliminado = await AlbumService.getById(id);

    if (!albumEliminado) {
      return res.status(404).json({ error: "Album no encontrado" });
    }

    const eliminado = await AlbumService.deleteById(id);

    if (eliminado) {
      res.json({ mensaje: "Album eliminado", album: albumEliminado });
    } else {
      res.status(404).json({ error: "Album no encontrado" });
    }
  } catch (error) {
    res.status(500).json({ error: "Error al eliminar el album" });
  }
});

// PUT /albums/:id
router.put("/:id", async function (req, res) {
  try {
    const id = req.params.id;
    const albumExistente = await AlbumService.getById(id);

    if (!albumExistente) {
      return res.status(404).json({ error: "Album no encontrado" });
    }

    const updatedFields = {
      titulo: req.body.titulo ?? albumExistente.titulo,
      artista: req.body.artista ?? albumExistente.artista,
      anio: req.body.anio ?? albumExistente.anio,
      genero: req.body.genero ?? albumExistente.genero,
      img: req.body.img ?? albumExistente.img,
    };

    const albumActualizado = await AlbumService.put(id, updatedFields);
    res.json(albumActualizado);
  } catch (error) {
    res.status(500).json({
      error: "Error al actualizar el album",
      detalles: error.message,
    });
  }
});

module.exports = router;

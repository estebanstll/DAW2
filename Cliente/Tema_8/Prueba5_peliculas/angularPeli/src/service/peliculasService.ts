import { Injectable } from '@angular/core';
import Pelicula from '../app/models/pelicula.model';

@Injectable({ providedIn: 'root' })
export class PeliculasService {
  // Endpoint base para películas
  private baseUrl = 'http://localhost:3000/peliculas';

  constructor() {}

  // GET all
  async getAll(): Promise<Pelicula[]> {
    const res = await fetch(this.baseUrl, { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Error fetching peliculas: ${res.status}`);
    return res.json();
  }

  // GET by id
  async getById(id: string | number): Promise<Pelicula> {
    const res = await fetch(`${this.baseUrl}/${id}`, { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Error fetching pelicula ${id}: ${res.status}`);
    return res.json();
  }

  // POST create
  async create(payload: Partial<Pelicula>): Promise<Pelicula> {
    const body = {
      id: payload.id,
      titulo: payload.titulo,
      anio: payload.anio,
      genero: payload.genero ?? null,
      valoracion: payload.valoracion ?? null,
      plataforma: payload.plataforma ?? null,
      img: payload.img ?? null,
    };

    const res = await fetch(this.baseUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(body),
    });
    if (!res.ok) throw new Error(`Error creating pelicula: ${res.status}`);
    return res.json();
  }

  // PUT update
  async update(id: string | number, payload: Partial<Pelicula>): Promise<Pelicula> {
    const res = await fetch(`${this.baseUrl}/${id}`, {
      method: 'PUT',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(payload),
    });
    if (!res.ok) throw new Error(`Error updating pelicula ${id}: ${res.status}`);
    return res.json();
  }

  // DELETE
  async delete(id: string | number): Promise<boolean> {
    const res = await fetch(`${this.baseUrl}/${id}`, { method: 'DELETE' });
    if (res.status === 404) return false;
    if (!res.ok) throw new Error(`Error deleting pelicula ${id}: ${res.status}`);
    return true;
  }
}

import { Injectable } from '@angular/core';

@Injectable({ providedIn: 'root' })
export class ConcesionarioService {
  // La API en el backend expone '/coches'
  private baseUrl = 'http://localhost:3000/coches';

  constructor() {}

  // GET all
  async getAll(): Promise<any[]> {
    const res = await fetch(this.baseUrl, { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Error fetching concesionario: ${res.status}`);
    return res.json();
  }

  // GET by id
  async getById(id: string | number): Promise<any> {
    const res = await fetch(`${this.baseUrl}/${id}`, { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Error fetching item ${id}: ${res.status}`);
    return res.json();
  }

  // POST create
  async create(payload: any): Promise<any> {
    // Asegurarse que el payload incluya los campos del modelo `coche`:
    // { marca: string, modelo: string, img?: string }
    const body = {
      marca: payload.marca,
      modelo: payload.modelo,
      img: payload.img ?? payload.imgUrl ?? null,
    };

    const res = await fetch(this.baseUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
      body: JSON.stringify(body),
    });
    if (!res.ok) throw new Error(`Error creating item: ${res.status}`);
    return res.json();
  }
}

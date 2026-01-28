import { Injectable } from '@angular/core';

export interface hospital {
  nombre: string;
  ubicacion: string;
}

@Injectable({
  providedIn: 'root',
})
export class HospitalService {
  private apiUrl = 'http://localhost:3000/hospital';

  constructor() {}

  async getHospitales(): Promise<hospital[]> {
    try {
      const response = await fetch(this.apiUrl);
      if (!response.ok) {
        throw new Error('Error al obtener hospitales');
      }
      const data = await response.json();
      return data;
    } catch (error) {
      console.error('Error en la petición:', error);
      return [];
    }
  }
}

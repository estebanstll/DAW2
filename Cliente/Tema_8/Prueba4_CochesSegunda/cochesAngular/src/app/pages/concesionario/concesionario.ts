import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Busqueda } from '../../component/busqueda/busqueda';
import { Coche } from '../../component/coche/coche';
import { ConcesionarioService } from '../../service/concesionarioService';

@Component({
  selector: 'app-concesionario',
  standalone: true,
  imports: [CommonModule, Busqueda, Coche],
  templateUrl: './concesionario.html',
  styleUrl: './concesionario.css',
})
export class Concesionario implements OnInit {
  coches: any[] = [];
  filteredCoches: any[] = [];

  constructor(private service: ConcesionarioService) {}

  async ngOnInit() {
    try {
      const data = await this.service.getAll();
      this.coches = Array.isArray(data) ? data : [];
      this.filteredCoches = [...this.coches];
    } catch (err) {
      console.error('Error cargando coches:', err);
      this.coches = [];
      this.filteredCoches = [];
    }
  }

  onSearch(criteria: any) {
    if (!criteria || Object.keys(criteria).length === 0) {
      this.filteredCoches = [...this.coches];
      return;
    }

    const cMarca = (criteria.marca || '').toString().toLowerCase();
    const cModelo = (criteria.modelo || '').toString().toLowerCase();
    const anoFrom = criteria.anoFrom != null ? Number(criteria.anoFrom) : null;
    const anoTo = criteria.anoTo != null ? Number(criteria.anoTo) : null;
    const precioFrom = criteria.precioFrom != null ? Number(criteria.precioFrom) : null;
    const precioTo = criteria.precioTo != null ? Number(criteria.precioTo) : null;

    this.filteredCoches = this.coches.filter((c: any) => {
      const carMarca = (c.marca || '').toString().toLowerCase();
      const carModelo = (c.modelo || '').toString().toLowerCase();
      const carAno = c.ano ?? c.anio ?? null;
      const carPrecio = c.precio ?? null;

      if (cMarca && !carMarca.includes(cMarca)) return false;
      if (cModelo && !carModelo.includes(cModelo)) return false;
      if (anoFrom != null && (carAno == null || Number(carAno) < anoFrom)) return false;
      if (anoTo != null && (carAno == null || Number(carAno) > anoTo)) return false;
      if (precioFrom != null && (carPrecio == null || Number(carPrecio) < precioFrom)) return false;
      if (precioTo != null && (carPrecio == null || Number(carPrecio) > precioTo)) return false;
      return true;
    });
  }
}

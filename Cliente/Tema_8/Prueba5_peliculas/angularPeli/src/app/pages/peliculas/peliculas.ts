import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { PeliculaComponent } from '../../component/pelicula/pelicula';
import { Busqueda } from '../../component/busqueda/busqueda';
import { PeliculasService } from '../../../service/peliculasService';
import Pelicula from '../../models/pelicula.model';

@Component({
  selector: 'app-peliculas',
  standalone: true,
  imports: [CommonModule, RouterModule, Busqueda, PeliculaComponent],
  templateUrl: './peliculas.html',
  styleUrls: ['./peliculas.css'],
})
export class Peliculas implements OnInit {
  peliculas: Pelicula[] = [];
  private allPeliculas: Pelicula[] = [];
  loading = false;
  error: string | null = null;

  constructor(
    private service: PeliculasService,
    private cd: ChangeDetectorRef,
  ) {}

  ngOnInit(): void {
    this.loadPeliculas();
  }

  async loadPeliculas() {
    this.loading = true;
    this.error = null;
    try {
      this.allPeliculas = await this.service.getAll();
      this.peliculas = [...this.allPeliculas];
      // Algunos entornos (fetch promesas) pueden resolverse fuera de Zone.js; forzamos detección
      this.cd.detectChanges();
    } catch (err: any) {
      this.error = err?.message ?? String(err);
    } finally {
      this.loading = false;
      this.cd.detectChanges();
    }
  }

  onSearch(criteria: any) {
    if (!criteria || Object.keys(criteria).length === 0) {
      this.peliculas = [...this.allPeliculas];
      return;
    }

    const texto = criteria.texto?.toString().trim().toLowerCase() || '';
    const plataforma = criteria.plataforma?.toString().trim().toLowerCase() || '';

    if (!texto && !plataforma) {
      this.peliculas = [...this.allPeliculas];
      return;
    }

    this.peliculas = this.allPeliculas.filter((p) => {
      const titulo = (p.titulo || '').toString().toLowerCase();
      const plat = (p.plataforma || '').toString().toLowerCase();

      let ok = true;
      if (texto) ok = ok && titulo.includes(texto);
      if (plataforma) ok = ok && plat.includes(plataforma);
      return ok;
    });
  }
}

import { Component, Input, OnChanges, SimpleChanges } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ChangeDetectorRef } from '@angular/core';
import Pelicula from '../../models/pelicula.model';
import { PeliculasService } from '../../../service/peliculasService';

@Component({
  selector: 'app-detalles',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './detalles.html',
  styleUrls: ['./detalles.css'],
})
export class Detalles implements OnChanges {
  @Input() id: number | null = null;

  pelicula: Pelicula | null = null;
  loading = false;
  error: string | null = null;

  constructor(
    private service: PeliculasService,
    private cd: ChangeDetectorRef,
  ) {}

  ngOnChanges(changes: SimpleChanges) {
    if (changes['id']) {
      this.loadPelicula();
    }
  }

  async loadPelicula() {
    this.pelicula = null;
    this.error = null;
    if (this.id === null || this.id === undefined) return;
    this.loading = true;
    try {
      const p = await this.service.getById(this.id);
      this.pelicula = p;
    } catch (err: any) {
      this.error = err?.message ?? String(err);
    } finally {
      this.loading = false;
      this.cd.detectChanges();
    }
  }

  onImgError(event: Event) {
    const img = event.target as HTMLImageElement;
    const defaultPath = '/assets/img/defecto.svg';
    if (img && img.src !== defaultPath) {
      img.src = defaultPath;
    }
  }
}

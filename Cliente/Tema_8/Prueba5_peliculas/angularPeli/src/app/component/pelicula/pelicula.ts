import { Component, Input } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterLink } from '@angular/router';
import Pelicula from '../../models/pelicula.model';
import { Router } from '@angular/router';

@Component({
  selector: 'app-pelicula',
  standalone: true,
  imports: [CommonModule, RouterLink],
  templateUrl: './pelicula.html',
  styleUrls: ['./pelicula.css'],
})
export class PeliculaComponent {
  @Input() pelicula: Pelicula | null = null;
  constructor(private router: Router) {}

  // Construye la ruta de la imagen tomando el nombre desde el objeto coche
  // Usa la carpeta `assets/img` para servir recursos estáticos correctamente en Angular
  getImagePath(): string {
    const file = this.pelicula?.img || 'defecto.svg';
    return `/assets/img/${file}`;
  }

  onImgError(event: Event) {
    const img = event.target as HTMLImageElement;
    const defaultPath = '/assets/img/defecto.svg';
    if (img && img.src !== defaultPath) {
      img.src = defaultPath;
    }
  }

  onDetailsClick() {
    if (this.pelicula) {
      this.router.navigate(['/peliculas', this.pelicula.id]);
    }
  }
}

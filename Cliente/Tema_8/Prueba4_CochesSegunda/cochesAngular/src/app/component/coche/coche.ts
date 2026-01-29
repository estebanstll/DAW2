import { Component, Input } from '@angular/core';

@Component({
  selector: 'app-coche',
  standalone: true,
  imports: [],
  templateUrl: './coche.html',
  styleUrl: './coche.css',
})
export class Coche {
  @Input() coche: { marca?: string; modelo?: string; img?: string } | null = null;

  // Construye la ruta de la imagen tomando el nombre desde el objeto coche
  // Usa la carpeta `assets/img` para servir recursos estáticos correctamente en Angular
  getImagePath(): string {
    const file = this.coche?.img || 'defecto.svg';
    return `/assets/img/${file}`;
  }

  onImgError(event: Event) {
    const img = event.target as HTMLImageElement;
    const defaultPath = '/assets/img/defecto.svg';
    if (img && img.src !== defaultPath) {
      img.src = defaultPath;
    }
  }

  // navigation to detalles removed — component deleted
}

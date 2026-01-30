import { Component, Input, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { Song } from '../../services/album-Service';

@Component({
  selector: 'app-canciones-album',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './canciones-album.html',
  styleUrl: './canciones-album.css',
})
export class CancionesAlbumComponent {
  @Input() songs: Song[] = [];
  @Output() listened = new EventEmitter<string>();
  @Output() ratingChanged = new EventEmitter<{ songId: string; rating: number }>();
  @Output() deleted = new EventEmitter<string>();

  onToggleListened(songId: string) {
    this.listened.emit(songId);
  }

  onSetRating(songId: string, rating: number) {
    this.ratingChanged.emit({ songId, rating });
  }

  onDelete(songId: string) {
    this.deleted.emit(songId);
  }

  renderStars(rating: number): number[] {
    return Array.from({ length: 5 }, (_, i) => i + 1);
  }
}

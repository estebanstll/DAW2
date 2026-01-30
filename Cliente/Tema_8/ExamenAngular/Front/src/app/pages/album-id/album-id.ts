import { Component, OnInit, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ActivatedRoute, Router } from '@angular/router';
import { AlbumService, Album, Song } from '../../services/album-Service';
import { CancionesAlbumComponent } from '../../component/canciones-album/canciones-album';

@Component({
  selector: 'app-album-id',
  standalone: true,
  imports: [CommonModule, CancionesAlbumComponent],
  templateUrl: './album-id.html',
  styleUrl: './album-id.css',
})
export class AlbumID implements OnInit {
  album: Album | null = null;
  songs: Song[] = [];
  albumId: string | null = null;

  constructor(
    private route: ActivatedRoute,
    private router: Router,
    private albumService: AlbumService,
    private cdr: ChangeDetectorRef,
  ) {}

  ngOnInit() {
    this.route.params.subscribe((params) => {
      this.albumId = params['id'];
      this.loadAlbum();
      this.loadSongs();
    });
  }

  async loadAlbum() {
    if (this.albumId) {
      const album = await this.albumService.getAlbumById(this.albumId);
      this.album = album || null;
      this.cdr.detectChanges();
    }
  }

  async loadSongs() {
    if (this.albumId) {
      this.songs = await this.albumService.getSongsByAlbumId(this.albumId);
      console.log('Canciones cargadas:', this.songs);
      this.cdr.detectChanges();
    }
  }

  goToAlbums() {
    this.router.navigate(['/albums']);
  }

  goToNewSong() {
    this.router.navigate([`/albums/${this.albumId}/songs/new`]);
  }

  async onListenedChange(songId: string) {
    await this.albumService.toggleListened(songId);
    await this.loadSongs();
  }

  async onRatingChanged(event: { songId: string; rating: number }) {
    await this.albumService.setRating(event.songId, event.rating);
    await this.loadSongs();
  }

  async onSongDeleted(songId: string) {
    await this.albumService.deleteSong(songId);
    await this.loadSongs();
  }
}

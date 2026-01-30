import { Component, OnInit, NgZone, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { FormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AlbumService, Album } from '../../services/album-Service';

@Component({
  selector: 'app-albums',
  standalone: true,
  imports: [CommonModule, FormsModule],
  templateUrl: './albums.html',
  styleUrl: './albums.css',
})
export class Albums implements OnInit {
  albums: Album[] = [];
  filteredAlbums: Album[] = [];
  genreFilter: string = '';
  artistFilter: string = '';

  constructor(
    private albumService: AlbumService,
    private router: Router,
    private ngZone: NgZone,
    private cdr: ChangeDetectorRef,
  ) {}

  ngOnInit() {
    this.loadAlbums();
  }

  async loadAlbums() {
    try {
      this.albums = await this.albumService.getAlbums();

      for (let album of this.albums) {
        const songs = await this.albumService.getSongsByAlbumId(album._id);
        album.numCanciones = songs.length;
      }

      this.applyFilters();
      this.cdr.detectChanges();
    } catch (error) {}
  }

  applyFilters() {
    this.filteredAlbums = this.albums.filter((album) => {
      const genreMatch =
        album.genre?.toLowerCase().includes(this.genreFilter.toLowerCase()) ?? true;

      return genreMatch;
    });

    this.filteredAlbums.sort((a, b) => b.year - a.year);
  }

  onGenreFilterChange() {
    this.applyFilters();
  }

  onArtistFilterChange() {
    this.applyFilters();
  }

  goToNewAlbum() {
    this.router.navigate(['/albums/new']);
  }

  onViewAlbum(id: string) {
    this.router.navigate(['/albums', id]);
  }

  async onDeleteAlbum(id: string) {
    try {
      await this.albumService.deleteAlbum(id);
      this.loadAlbums();
    } catch (error) {}
  }
}

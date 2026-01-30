import { Component, OnInit } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { ActivatedRoute, Router } from '@angular/router';
import { AlbumService, Album } from '../../services/album-Service';

@Component({
  selector: 'app-canciones-album',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './canciones-album.html',
  styleUrl: './canciones-album.css',
})
export class CancionesAlbum implements OnInit {
  form: FormGroup;
  album: Album | null = null;
  albumId: string | null = null;

  constructor(
    private fb: FormBuilder,
    private route: ActivatedRoute,
    private router: Router,
    private albumService: AlbumService,
  ) {
    this.form = this.fb.group({
      title: ['', Validators.required],
      duration: ['', Validators.required],
      rating: [3, Validators.required],
    });
  }

  ngOnInit() {
    this.route.params.subscribe((params) => {
      this.albumId = params['id'];
      this.loadAlbum();
    });
  }

  async loadAlbum() {
    if (this.albumId) {
      const album = await this.albumService.getAlbumById(this.albumId);
      this.album = album || null;
    }
  }

  async onSubmit() {
    if (this.form.valid && this.albumId) {
      await this.albumService.createSong({
        ...this.form.value,
        listened: false,
        albumID: this.albumId,
      });
      this.router.navigate([`/albums/${this.albumId}`]);
    }
  }

  onCancel() {
    this.router.navigate([`/albums/${this.albumId}`]);
  }
}

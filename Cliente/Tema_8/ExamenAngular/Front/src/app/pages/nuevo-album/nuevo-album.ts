import { Component } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { AlbumService } from '../../services/album-Service';

@Component({
  selector: 'app-nuevo-album',
  standalone: true,
  imports: [ReactiveFormsModule],
  templateUrl: './nuevo-album.html',
  styleUrl: './nuevo-album.css',
})
export class NuevoAlbum {
  form: FormGroup;

  constructor(
    private fb: FormBuilder,
    private albumService: AlbumService,
    private router: Router,
  ) {
    this.form = this.fb.group({
      title: ['', Validators.required],
      artist: ['', Validators.required],
      year: ['', Validators.required],
      genre: ['', Validators.required],
    });
  }

  onSubmit() {
    if (this.form.valid) {
      this.albumService.createAlbum(this.form.value);
      this.router.navigate(['/albums']);
    }
  }

  onCancel() {
    this.router.navigate(['/albums']);
  }
}

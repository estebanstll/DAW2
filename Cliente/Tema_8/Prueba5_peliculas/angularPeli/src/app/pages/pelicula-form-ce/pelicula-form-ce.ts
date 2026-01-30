import { Component, Output, EventEmitter } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { ReactiveFormsModule, FormBuilder, FormGroup, Validators } from '@angular/forms';
import { PeliculasService } from '../../../service/peliculasService';
import Pelicula from '../../models/pelicula.model';

@Component({
  selector: 'app-pelicula-form-ce',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule, RouterModule],
  templateUrl: './pelicula-form-ce.html',
  styleUrls: ['./pelicula-form-ce.css'],
})
export class PeliculaFormCE {
  form: FormGroup;
  loading = false;
  error: string | null = null;

  @Output() saved = new EventEmitter<Pelicula>();

  constructor(
    private service: PeliculasService,
    private fb: FormBuilder,
  ) {
    this.form = this.fb.group({
      id: [''],
      titulo: ['', Validators.required],
      anio: [''],
      genero: [''],
      valoracion: [''],
      plataforma: [''],
      img: [''],
    });
  }

  async create() {
    this.error = null;
    if (this.form.invalid) {
      this.error = 'El título es obligatorio';
      return;
    }
    this.loading = true;
    try {
      const payload: Partial<Pelicula> = { ...this.form.value };
      if (!payload.id) delete payload.id;
      const created = await this.service.create(payload);
      this.saved.emit(created as Pelicula);
      this.form.reset();
    } catch (err: any) {
      this.error = err?.message ?? String(err);
    } finally {
      this.loading = false;
    }
  }

  async modify() {
    this.error = null;
    const id = (this.form.get('id')?.value ?? '').toString();
    if (!id) {
      this.error = 'Id necesario para modificar';
      return;
    }
    this.loading = true;
    try {
      const payload: Partial<Pelicula> = { ...this.form.value };
      delete payload.id;
      const updated = await this.service.update(id, payload);
      this.saved.emit(updated as Pelicula);
    } catch (err: any) {
      this.error = err?.message ?? String(err);
    } finally {
      this.loading = false;
    }
  }

  resetForm() {
    this.form.reset();
    this.error = null;
  }
}

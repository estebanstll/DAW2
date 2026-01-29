import { Component, inject, ChangeDetectorRef } from '@angular/core';
import { FormBuilder, FormGroup, Validators, ReactiveFormsModule } from '@angular/forms';
import { Router } from '@angular/router';
import { CommonModule } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [CommonModule, ReactiveFormsModule],
  templateUrl: './login.html',
  styleUrl: './login.css',
})
export class Login {
  private formBuilder = inject(FormBuilder);
  private cdr = inject(ChangeDetectorRef);
  private router = inject(Router);

  formLogin: FormGroup = this.formBuilder.group({
    nombre: ['', Validators.required],
    contraseña: ['', Validators.required],
  });

  async login() {
    if (this.formLogin.valid) {
      try {
        const nombre = this.formLogin.get('nombre')?.value;
        const contraseña = this.formLogin.get('contraseña')?.value;

        const usuario = await this.getUsuario(nombre as string);

        // Access property safely using bracket notation because the field name has a special character
        const serverPass = usuario ? usuario['contraseña'] : null;

        if (usuario && serverPass === contraseña) {
          localStorage.setItem('usuario', JSON.stringify(usuario));
          this.cdr.detectChanges();
          // redirect to inicio (main app area) after successful login
          this.router.navigate(['/inicio']);
        } else {
          alert('Contraseña incorrecta');
          this.cdr.detectChanges();
        }
      } catch (error) {
        alert('Usuario no encontrado');
        this.cdr.detectChanges();
      }
    }
  }

  async getUsuario(nombre: string): Promise<any> {
    const url = `http://localhost:3000/usuarios/${encodeURIComponent(nombre)}`;
    const res = await fetch(url, { method: 'GET', headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error('Usuario no encontrado');
    return res.json();
  }
}

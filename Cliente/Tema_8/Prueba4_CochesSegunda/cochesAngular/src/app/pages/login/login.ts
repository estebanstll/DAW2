import { Component, inject, ChangeDetectorRef } from '@angular/core';
import {
  FormBuilder,
  FormControl,
  FormGroup,
  Validators,
  ReactiveFormsModule,
} from '@angular/forms';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  imports: [ReactiveFormsModule],
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

        if (usuario && usuario.contraseña === contraseña) {
          localStorage.setItem('usuario', JSON.stringify(usuario));
          this.cdr.detectChanges();
          this.router.navigate(['/dashboard']);
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

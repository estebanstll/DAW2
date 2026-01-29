import { Routes } from '@angular/router';
import { Login } from './pages/login/login';
import { Inicio } from './pages/inicio/inicio';
import { Concesionario } from './pages/concesionario/concesionario';
import { Vender } from './pages/vender/vender';

export const routes: Routes = [
  { path: '', component: Login },
  { path: 'inicio', component: Inicio },
  { path: 'concesionario', component: Concesionario },
  { path: 'vender', component: Vender },
];

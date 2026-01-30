import { Routes } from '@angular/router';
import { Peliculas } from './pages/peliculas/peliculas';
import { Detalles as DetallesPage } from './pages/detalles/detalles';
import { PeliculaFormCE } from './pages/pelicula-form-ce/pelicula-form-ce';

export const routes: Routes = [
  { path: '', component: Peliculas },
  { path: 'peliculas/form', component: PeliculaFormCE },
  { path: 'peliculas/:id', component: DetallesPage },
];

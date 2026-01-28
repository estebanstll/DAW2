import { Routes } from '@angular/router';
import { Home } from './pages/home/home';
import { Coches } from './pages/coches/coches';

export const routes: Routes = [
  { path: '', component: Home },
  { path: 'home', component: Home },
  { path: 'coches', component: Coches },
];

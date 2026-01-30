import { Routes } from '@angular/router';
import { Albums } from './pages/albums/albums';
import { AlbumID } from './pages/album-id/album-id';
import { NuevoAlbum } from './pages/nuevo-album/nuevo-album';
import { CancionesAlbum } from './pages/canciones-album/canciones-album';

export const routes: Routes = [
  { path: '', redirectTo: '/albums', pathMatch: 'full' },
  { path: 'albums', component: Albums },
  { path: 'albums/new', component: NuevoAlbum },
  { path: 'albums/:id', component: AlbumID },
  { path: 'albums/:id/songs', component: CancionesAlbum },
  { path: 'albums/:id/songs/new', component: CancionesAlbum },
];

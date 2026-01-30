import { Injectable } from '@angular/core';

export interface Album {
  _id: string;
  title: string;
  artist: string;
  year: number;
  genre: string;
  numCanciones?: number;
  img?: string;
}

export interface Song {
  _id: string;
  title: string;
  duration: number;
  rating: number;
  listened: boolean;
  albumID: string;
}

@Injectable({
  providedIn: 'root',
})
export class AlbumService {
  private apiUrl = 'http://localhost:3000';

  constructor() {}

  async getAlbums(): Promise<Album[]> {
    const res = await fetch(`${this.apiUrl}/albums`, { headers: { Accept: 'application/json' } });
    if (!res.ok) throw new Error(`Error fetching albums: ${res.status}`);
    const data = await res.json();
    return data.map((album: any) => ({
      _id: album._id,
      title: album.titulo,
      artist: album.artista,
      year: album.anio,
      genre: album.genero,
      numCanciones: album.numCanciones || 0,
      img: album.img,
    }));
  }

  async getAlbumById(id: number | string): Promise<Album | undefined> {
    const res = await fetch(`${this.apiUrl}/albums/${id}`, {
      headers: { Accept: 'application/json' },
    });
    if (res.status === 404) {
      return undefined;
    }
    if (!res.ok) throw new Error(`Error fetching album ${id}: ${res.status}`);
    const album = await res.json();
    return {
      _id: album._id,
      title: album.titulo,
      artist: album.artista,
      year: album.anio,
      genre: album.genero,
      numCanciones: album.numCanciones || 0,
      img: album.img,
    };
  }

  async createAlbum(album: Omit<Album, '_id'>): Promise<Album> {
    const payload = {
      titulo: album.title,
      artista: album.artist,
      anio: album.year,
      genero: album.genre,
      img: album.img,
    };
    const res = await fetch(`${this.apiUrl}/albums`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(payload),
    });
    if (!res.ok) throw new Error(`Error creating album: ${res.status}`);
    const createdAlbum = await res.json();
    return {
      _id: createdAlbum._id,
      title: createdAlbum.titulo,
      artist: createdAlbum.artista,
      year: createdAlbum.anio,
      genre: createdAlbum.genero,
      numCanciones: createdAlbum.numCanciones || 0,
      img: createdAlbum.img,
    };
  }

  async updateAlbum(id: number | string, album: Partial<Album>): Promise<Album> {
    const res = await fetch(`${this.apiUrl}/albums/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(album),
    });
    if (!res.ok) throw new Error(`Error updating album ${id}: ${res.status}`);
    return res.json();
  }

  async deleteAlbum(id: number | string): Promise<boolean> {
    const res = await fetch(`${this.apiUrl}/albums/${id}`, { method: 'DELETE' });
    if (res.status === 404) return false;
    if (!res.ok) throw new Error(`Error deleting album ${id}: ${res.status}`);
    return true;
  }

  async getSongs(): Promise<Song[]> {
    const res = await fetch(`${this.apiUrl}/canciones`, {
      headers: { Accept: 'application/json' },
    });
    if (!res.ok) throw new Error(`Error fetching songs: ${res.status}`);
    const data = await res.json();
    return data.map((song: any) => ({
      _id: song._id,
      title: song.titulo,
      duration: song.duracion,
      rating: song.rating,
      listened: song.escuchado,
      albumID: song.albumID,
    }));
  }

  async getSongsByAlbumId(albumId: number | string): Promise<Song[]> {
    const res = await fetch(`${this.apiUrl}/albums/${albumId}/songs`, {
      headers: { Accept: 'application/json' },
    });
    if (!res.ok) throw new Error(`Error fetching songs for album ${albumId}: ${res.status}`);
    const data = await res.json();
    return data.map((song: any) => ({
      _id: song._id,
      title: song.titulo,
      duration: song.duracion,
      rating: song.rating,
      listened: song.escuchado,
      albumID: song.albumID,
    }));
  }

  async createSong(song: Omit<Song, '_id'>): Promise<Song> {
    const res = await fetch(`${this.apiUrl}/canciones`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(song),
    });
    if (!res.ok) throw new Error(`Error creating song: ${res.status}`);
    return res.json();
  }

  async updateSong(id: number | string, song: Partial<Song>): Promise<Song> {
    const res = await fetch(`${this.apiUrl}/canciones/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify(song),
    });
    if (!res.ok) throw new Error(`Error updating song ${id}: ${res.status}`);
    return res.json();
  }

  async deleteSong(id: number | string): Promise<boolean> {
    const res = await fetch(`${this.apiUrl}/canciones/${id}`, { method: 'DELETE' });
    if (res.status === 404) return false;
    if (!res.ok) throw new Error(`Error deleting song ${id}: ${res.status}`);
    return true;
  }

  async toggleListened(id: number | string): Promise<Song> {
    const res = await fetch(`${this.apiUrl}/canciones/${id}`, {
      headers: { Accept: 'application/json' },
    });
    if (!res.ok) throw new Error(`Error fetching song ${id}: ${res.status}`);
    const song: Song = await res.json();

    const updateRes = await fetch(`${this.apiUrl}/canciones/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({ listened: !song.listened }),
    });
    if (!updateRes.ok)
      throw new Error(`Error toggling listened for song ${id}: ${updateRes.status}`);
    return updateRes.json();
  }

  async setRating(id: number | string, rating: number): Promise<Song> {
    const res = await fetch(`${this.apiUrl}/canciones/${id}`, {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({ rating }),
    });
    if (!res.ok) throw new Error(`Error setting rating for song ${id}: ${res.status}`);
    return res.json();
  }
}

import { Injectable } from '@angular/core';
import { Observable, from } from 'rxjs';

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
export class CancionesService {
  private apiUrl = 'http://localhost:3000';

  constructor() {}

  getSongs(): Observable<Song[]> {
    return from(fetch(`${this.apiUrl}/canciones`).then((res) => res.json()));
  }

  getSongById(id: number | string): Observable<Song | undefined> {
    return from(
      fetch(`${this.apiUrl}/canciones/${id}`).then((res) => {
        if (res.status === 404) {
          return undefined;
        }
        return res.json();
      }),
    );
  }

  getSongsByAlbumId(albumId: number | string): Observable<Song[]> {
    return from(fetch(`${this.apiUrl}/albums/${albumId}/songs`).then((res) => res.json()));
  }

  createSong(song: Omit<Song, '_id'>): Observable<Song> {
    return from(
      fetch(`${this.apiUrl}/canciones`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(song),
      }).then((res) => res.json()),
    );
  }

  updateSong(id: number | string, song: Partial<Song>): Observable<Song> {
    return from(
      fetch(`${this.apiUrl}/canciones/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(song),
      }).then((res) => res.json()),
    );
  }

  deleteSong(id: number | string): Observable<any> {
    return from(
      fetch(`${this.apiUrl}/canciones/${id}`, {
        method: 'DELETE',
      }).then((res) => res.json()),
    );
  }

  toggleListened(id: number | string): Observable<Song> {
    return new Observable((observer) => {
      fetch(`${this.apiUrl}/canciones/${id}`)
        .then((res) => res.json())
        .then((song: Song) => {
          return fetch(`${this.apiUrl}/canciones/${id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
            },
            body: JSON.stringify({ listened: !song.listened }),
          }).then((res) => res.json());
        })
        .then((updatedSong) => {
          observer.next(updatedSong);
          observer.complete();
        })
        .catch((error) => observer.error(error));
    });
  }

  setRating(id: number | string, rating: number): Observable<Song> {
    return from(
      fetch(`${this.apiUrl}/canciones/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ rating }),
      }).then((res) => res.json()),
    );
  }
}

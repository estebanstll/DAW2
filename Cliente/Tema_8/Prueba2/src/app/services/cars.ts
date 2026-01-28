import { Injectable } from '@angular/core';

export interface Car {
  name: string;
  image: string;
}

@Injectable({
  providedIn: 'root',
})
export class CarsService {
  constructor() {}

  getCars(): Car[] {
    return [
      {
        name: 'BMW M4',
        image: 'assets/cars/bmw-m4.jpg'
      },
      {
        name: 'Audi R8',
        image: 'assets/cars/audi-r8.jpg'
      },
      {
        name: 'Mercedes AMG GT',
        image: 'assets/cars/amg-gt.jpg'
      }
    ];
  }
}
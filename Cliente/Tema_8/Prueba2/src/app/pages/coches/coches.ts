import { Component } from '@angular/core';
import { Car, CarsService } from '../../services/cars';
import { CommonModule } from '@angular/common';
import { Coche } from '../../component/coche/coche';

@Component({
  selector: 'app-coches',
  imports: [CommonModule, Coche],
  templateUrl: './coches.html',
  styleUrl: './coches.css',
})
export class Coches {
  cars: Car[] = [];

  constructor(private CarsService: CarsService) {}

  ngOnInit(): void {
    this.cars = this.CarsService.getCars();
  }
}

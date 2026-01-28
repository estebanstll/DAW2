import { Component, Input } from '@angular/core';
import { Car } from '../../services/cars';

@Component({
  selector: 'app-coche',
  imports: [],
  templateUrl: './coche.html',
  styleUrl: './coche.css',
})
export class Coche {
  @Input() car!: Car;
}

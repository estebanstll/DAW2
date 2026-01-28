import { Component, Input } from '@angular/core';
import { hospital } from '../../services/hospital-service';

@Component({
  selector: 'app-hospital-component',
  imports: [],
  templateUrl: './hospital-component.html',
  styleUrl: './hospital-component.css',
})
export class HospitalComponent {
  @Input() hospital!: hospital;
}

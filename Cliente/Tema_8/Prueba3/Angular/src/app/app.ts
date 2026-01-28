import { Component, signal } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { HospitalComponent } from './component/hospital-component/hospital-component';

@Component({
  selector: 'app-root',
  imports: [RouterOutlet, HospitalComponent],
  templateUrl: './app.html',
  styleUrls: ['./app.css'],
})
export class App {
  protected readonly title = signal('plantilla');
}

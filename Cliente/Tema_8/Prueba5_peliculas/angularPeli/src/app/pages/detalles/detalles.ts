import { Component } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { Detalles as DetallesComponent } from '../../component/detalles/detalles';

@Component({
  selector: 'app-detalles-page',
  standalone: true,
  imports: [CommonModule, RouterModule, DetallesComponent],
  templateUrl: './detalles.html',
  styleUrls: ['./detalles.css'],
})
export class Detalles {
  id: number | null = null;

  constructor(private route: ActivatedRoute) {
    const param = this.route.snapshot.paramMap.get('id');
    this.id = param ? parseInt(param, 10) : null;
  }
}

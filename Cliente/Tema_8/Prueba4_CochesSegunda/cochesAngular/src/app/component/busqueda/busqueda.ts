import { Component, Output, EventEmitter } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-busqueda',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './busqueda.html',
  styleUrl: './busqueda.css',
})
export class Busqueda {
  marca: string = '';
  modelo: string = '';
  // only marca and modelo are used for search

  @Output() search = new EventEmitter<any>();

  onSearch() {
    const criteria: any = {};
    if (this.marca) criteria.marca = this.marca;
    if (this.modelo) criteria.modelo = this.modelo;
    this.search.emit(criteria);
  }

  onReset() {
    this.marca = '';
    this.modelo = '';
    // emit empty criteria
    this.search.emit({});
  }
}

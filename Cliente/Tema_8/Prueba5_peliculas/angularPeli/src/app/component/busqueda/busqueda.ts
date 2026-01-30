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
  texto: string = '';
  plataforma: string = '';

  @Output() search = new EventEmitter<any>();

  onSearch() {
    const criteria: any = {};
    if (this.texto) criteria.texto = this.texto;
    if (this.plataforma) criteria.plataforma = this.plataforma;
    this.search.emit(criteria);
  }

  onReset() {
    this.texto = '';
    this.plataforma = '';
    // emit empty criteria
    this.search.emit({});
  }
}

import { Component, ChangeDetectorRef } from '@angular/core';
import { CommonModule } from '@angular/common';
import { hospital, HospitalService } from '../../services/hospital-service';
import { HospitalComponent } from '../../component/hospital-component/hospital-component';

@Component({
  selector: 'app-hospital',
  imports: [CommonModule, HospitalComponent],
  templateUrl: './hospital.html',

  styleUrl: './hospital.css',
})
export class Hospital {
  hospital: hospital[] = [];

  constructor(
    private hospitalService: HospitalService,
    private cdr: ChangeDetectorRef,
  ) {}

  async carga() {
    const h = await this.hospitalService.getHospitales();
    return h;
  }

  async ngOnInit() {
    this.hospital = await this.carga();
    this.cdr.detectChanges();
  }
}

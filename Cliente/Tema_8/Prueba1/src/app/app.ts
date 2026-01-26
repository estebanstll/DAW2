import { Component, inject } from "@angular/core";
import { Casa as CasaComponent } from "./components/casa/casa";
import { Casa } from "./interfaces/casa";
import { CasaService } from "./services/casa-service";

@Component({
  selector: "app-root",
  imports: [CasaComponent],
  templateUrl: `./app.html`,
})
export class App {
  casaService: CasaService = inject(CasaService);
  casas: Array<Casa> = [];
  constructor() {
    this.casas = this.casaService.getCasas();
  }
}

import { Component, Input } from "@angular/core";
import { Casa as casaPrueba } from "../../interfaces/casa";
@Component({
  selector: "app-casa",
  imports: [],
  templateUrl: `./casa.html`,
  styleUrls: [`./casa.css`],
})
export class Casa {
  @Input() casa: casaPrueba = { nombre: "" };
}

import { Injectable } from "@angular/core";
import { Casa } from "../interfaces/casa";

@Injectable({
  providedIn: "root",
})
export class CasaService {
  getCasas(): Array<Casa> {
    const casas: Casa[] = [
      { nombre: "Juan" },
      { nombre: "María" },
      { nombre: "Pedro" },
      { nombre: "Ana" },
      { nombre: "Luis" },
      { nombre: "Carmen" },
      { nombre: "José" },
      { nombre: "Laura" },
      { nombre: "Carlos" },
      { nombre: "Sofía" },
    ];

    return casas;
  }
}

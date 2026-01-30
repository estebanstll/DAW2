export interface Pelicula {
  id: number;
  titulo: string;
  anio: number;
  genero?: string;
  valoracion?: number;
  plataforma?: string;
  img?: string;
}

export default Pelicula;

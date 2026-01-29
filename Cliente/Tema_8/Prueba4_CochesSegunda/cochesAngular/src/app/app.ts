import { Component, signal, inject } from '@angular/core';
import { Router, RouterOutlet, NavigationEnd } from '@angular/router';
import { CommonModule } from '@angular/common';
import { filter } from 'rxjs/operators';
import { Navbar } from './component/navbar/navbar';

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [CommonModule, RouterOutlet, Navbar],
  templateUrl: './app.html',
  styleUrls: ['./app.css'],
})
export class App {
  protected readonly title = signal('plantilla');
  showNavbar = true;
  private router = inject(Router);

  constructor() {
    // hide navbar on login page (path '/')
    this.showNavbar = this.router.url !== '/';
    this.router.events.pipe(filter((e: any) => e instanceof NavigationEnd)).subscribe((e: any) => {
      const url = e.urlAfterRedirects ?? e.url;
      this.showNavbar = url !== '/';
    });
  }
}

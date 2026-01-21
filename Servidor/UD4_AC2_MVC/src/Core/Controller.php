<?php
namespace Acme\IntranetRestaurante\Core;

class Controller
{
    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require __DIR__ . '/../View/' . $view . '.php';
    }
}

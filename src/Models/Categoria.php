<?php

namespace Models;

use Lib\BaseDatos;

class Categoria
{
    // Constructor con promoción de propiedades
    public function __construct(
        private int $id,
        private string $nombre,
        private BaseDatos $BaseDatos = new BaseDatos()
    ) {}

    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }
}
?>
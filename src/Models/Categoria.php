<?php

namespace Models;

use Lib\BaseDatos;

class Categoria
{
    // Atributos
    private int $id;
    private string $nombre;
    private BaseDatos $BaseDatos;

    // Construcutor

    public function __construct()
    {
        $this->BaseDatos = new BaseDatos();
    }

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

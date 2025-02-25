<?php

namespace Models;

use Lib\BaseDatos;


class Producto
{
    // Constructor con promoción de propiedades
    public function __construct(
        // Los valores por defecto son null para que no haya problemas al crear un objeto sin parámetros
        private ?int $id = null,
        private ?int $id_categoria = null,
        private ?string $nombre = null,
        private ?string $descripcion = null,
        private ?float $precio = null,
        private ?int $stock = null,
        private ?string $imagen = null,
        private ?string $oferta = null,
        private ?string $fecha = null, // La fecha tiene el formato "Y-m-d" en PHPMyAdmin
        private BaseDatos $BaseDatos = new BaseDatos()
    ) {}
    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getIdCategoria(): int
    {
        return $this->id_categoria;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    public function getOferta(): string
    {
        return $this->oferta;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    // Setters

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setIdCategoria(int $id_categoria): void
    {
        $this->id_categoria = $id_categoria;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }

    public function setOferta(string $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }
}

<?php

namespace Services;

use Repositories\CarritoRepository;

class CarritoServices
{
    private CarritoRepository $repo;

    public function __construct(CarritoRepository $repo)
    {
        $this->repo = $repo;
    }

    public function guardarProducto($usuarioId, $productoId, $cantidad)
    {
        return $this->repo->guardarProducto($usuarioId, $productoId, $cantidad);
    }

    public function obtenerCarrito($usuarioId)
    {
        return $this->repo->obtenerCarrito($usuarioId);
    }

    public function eliminarProducto($usuarioId, $productoId)
    {
        return $this->repo->eliminarProducto($usuarioId, $productoId);
    }

    public function guardarCarrito($usuarioId, $carrito)
    {
        return $this->repo->guardarCarrito($usuarioId, $carrito);
    }
}

?>

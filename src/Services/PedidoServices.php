<?php

namespace Services;

use Repositories\PedidoRepository;

class PedidoServices
{
    private PedidoRepository $pedidoRepository;

    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }

    public function obtenerTodosPedidos()
    {
        return $this->pedidoRepository->obtenerTodosPedidos();
    }

    public function getById($id)
    {
        return $this->pedidoRepository->getById($id);
    }

    public function getByUsuario($usuario_id)
    {
        return $this->pedidoRepository->getByUsuario($usuario_id);
    }

    public function delete($id)
    {
        return $this->pedidoRepository->delete($id);
    }

    public function update($id, $fecha, $hora, $coste, $estado, $usuario_id)
    {
        return $this->pedidoRepository->update($id, $fecha, $hora, $coste, $estado, $usuario_id);
    }

    public function getProductosPedido($pedido_id)
    {
        return $this->pedidoRepository->getProductosPedido($pedido_id);
    }

    public function getCantidadProducto($pedido_id, $producto_id)
    {
        return $this->pedidoRepository->getCantidadProducto($pedido_id, $producto_id);
    }

    public function calcularTotal($carrito)
    {
        return $this->pedidoRepository->calcularTotal($carrito);
    }

    public function guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora)
    {
        return $this->pedidoRepository->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);
    }

    public function guardarLineaPedido($pedido_id, $carrito)
    {
        return $this->pedidoRepository->guardarLineaPedido($pedido_id, $carrito);
    }

    public function create($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito)
    {

        return $this->pedidoRepository->create($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito);
    }

    public function updateEstado($id_pedido)
    {
        return $this->pedidoRepository->updateEstado($id_pedido);
    }
}

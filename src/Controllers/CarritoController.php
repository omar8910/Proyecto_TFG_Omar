<?php

namespace Controllers;

use Lib\Pages;
use Services\ProductoServices;
use Repositories\ProductoRepository;
use Services\CarritoServices;
use Repositories\CarritoRepository;

class CarritoController
{
    private ProductoServices $productoServices;
    private CarritoServices $carritoServices;
    private CarritoRepository $carritoRepository;
    private Pages $pages;


    public function __construct()
    {
        $this->productoServices = new ProductoServices(new ProductoRepository());
        $this->carritoServices = new CarritoServices(new CarritoRepository());
        $this->pages = new Pages();
    }

    // Método para agregar un producto al carrito
    public function agregarProducto()
    {
        $id_producto = $_GET['id'];
        $producto = $this->productoServices->getById($id_producto);
        if ($producto) {
            // Bloqueo: si el stock es 0, no permitir agregar al carrito
            if (isset($producto['stock']) && $producto['stock'] == 0) {
                $_SESSION['error_carrito'] = 'No puedes añadir este producto al carrito porque no hay stock disponible.';
                header('Location:' . BASE_URL . 'Carrito/verCarrito');
                return;
            }
            if (!isset($_SESSION['carrito'][$id_producto])) {
                $_SESSION['carrito'][$id_producto] = $producto;
                $_SESSION['carrito'][$id_producto]['cantidad'] = 1;
            } else {
                $_SESSION['carrito'][$id_producto]['cantidad']++;
            }
            // Guardar carrito completo en BD si usuario logueado
            if (isset($_SESSION['usuario'])) {
                $usuarioId = $_SESSION['usuario']->id;
                $this->carritoServices->guardarCarrito($usuarioId, $_SESSION['carrito']);
            }
        }
        header('Location:' . BASE_URL . 'Carrito/verCarrito');
    }

    // Método para eliminar un producto del carrito
    public function eliminarProducto($id)
    {
        $id_producto = $id;
        if (isset($_SESSION['carrito'][$id_producto])) {
            unset($_SESSION['carrito'][$id_producto]);
            // Guardar carrito completo en BD si usuario logueado
            if (isset($_SESSION['usuario'])) {
                $usuarioId = $_SESSION['usuario']->id;
                $this->carritoServices->guardarCarrito($usuarioId, $_SESSION['carrito']);
            }
        }
        header('Location:' . BASE_URL . 'Carrito/verCarrito');
    }

    // Método para mostrar el carrito
    public function mostrarCarrito()
    {
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        // Comprobar si hay productos con stock 0
        $productos = $_SESSION['carrito'];
        $cantidadProductos = $this->cantidadProductos();
        $cantidadDinero = $this->cantidadDineroTotal();
        $this->pages->render('Carrito/verCarrito', ['productos' => $productos, 'cantidadProductos' => $cantidadProductos, 'cantidadDinero' => $cantidadDinero]);
    }

    // Eliminar todos los productos del carrito
    public function vaciarCarrito()
    {
        unset($_SESSION['carrito']);
        if (isset($_SESSION['usuario'])) {
            $usuarioId = $_SESSION['usuario']->id;
            $this->carritoServices->guardarCarrito($usuarioId, []);
        }
        header('Location:' . BASE_URL . 'Carrito/verCarrito');
    }

    // Sumar la cantidad de productos
    public function sumarProductos($id)
    {
        $id_producto = $id;

        if (isset($_SESSION['carrito'][$id_producto])) {
            // Obtener el stock del producto
            $stockDisponible = $_SESSION['carrito'][$id_producto]['stock'];

            // Comprobar si se puede añadir más
            if ($_SESSION['carrito'][$id_producto]['cantidad'] < $stockDisponible) {
                $_SESSION['carrito'][$id_producto]['cantidad']++;
            } else {
                // Guardar mensaje de error en sesión
                $_SESSION['error_carrito'] = "No puedes agregar más de " . $stockDisponible . " unidades de este producto.";
            }
        }
        // Guardar en BD si usuario logueado
        if (isset($_SESSION['usuario'])) {
            $usuarioId = $_SESSION['usuario']->id;
            $this->carritoServices->guardarCarrito($usuarioId, $_SESSION['carrito']);
        }
        header('Location:' . BASE_URL . 'Carrito/verCarrito');
    }

    // Restar la cantidad de productos
    public function restarProductos($id)
    {
        $id_producto = $id;
        if (isset($_SESSION['carrito'][$id_producto])) {
            $_SESSION['carrito'][$id_producto]['cantidad']--;
            if ($_SESSION['carrito'][$id_producto]['cantidad'] == 0) {
                unset($_SESSION['carrito'][$id_producto]);
            }
        }
        // Guardar en BD si usuario logueado
        if (isset($_SESSION['usuario'])) {
            $usuarioId = $_SESSION['usuario']->id;
            $this->carritoServices->guardarCarrito($usuarioId, $_SESSION['carrito']);
        }
        header('Location:' . BASE_URL . 'Carrito/verCarrito');
    }

    // Método para obtener la cantidad de productos
    public function cantidadProductos()
    {
        $cantidadProductos = 0;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $producto) {
                $cantidadProductos += $producto['cantidad'];
            }
        }
        return $cantidadProductos;
    }

    public function cantidadDineroTotal()
    {
        $cantidadDinero = 0;
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $producto) {
                $cantidadDinero += $producto['cantidad'] * $producto['precio'];
            }
        }
        return $cantidadDinero;
    }

    // Método para cargar el carrito desde la base de datos
    public function cargarCarritoDesdeBD()
    {
        if (isset($_SESSION['usuario'])) {
            $usuarioId = $_SESSION['usuario']->id;
            $carritoBD = $this->carritoServices->obtenerCarrito($usuarioId);
            foreach ($carritoBD as $item) {
                $producto = $this->productoServices->getById($item['producto_id']);
                if ($producto) {
                    $_SESSION['carrito'][$item['producto_id']] = $producto;
                    $_SESSION['carrito'][$item['producto_id']]['cantidad'] = $item['cantidad'];
                }
            }
        }
    }
}

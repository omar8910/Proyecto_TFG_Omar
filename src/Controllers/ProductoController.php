<?php

namespace Controllers;

use Lib\Pages;
use Repositories\ProductoRepository;
use Services\ProductoServices;
use Services\CategoriaServices;
use Repositories\CategoriaRepository;


class ProductoController
{
    private Pages $pages;
    private ProductoServices $productoServices;
    private CategoriaServices $categoriaServices;

    public function __construct()
    {
        $this->pages = new Pages();
        $this->productoServices = new ProductoServices(new ProductoRepository());
        $this->categoriaServices = new CategoriaServices(new CategoriaRepository()); 
    }

    // Método para gestionar los productos
    public function gestionarProductos()
    {
        $productos = $this->productoServices->obtenerTodosProductos();
        $categorias = $this->categoriaServices->obtenerTodasCategorias();
        $this->pages->render("Administrador/gestionarProductos", ["productos" => $productos, "categorias" => $categorias]);
    }

    // Método para crear un producto
    public function crearProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $stock = $_POST['stock'];
            $categoria_id = $_POST['categoria_id'];
            $imagen = $_FILES['imagen'] ?? null;

            $errores = $this->validarProducto($nombre, $descripcion, $precio, $stock, $categoria_id, $imagen);
            if (!empty($errores)) {
                $categorias = $this->categoriaServices->obtenerTodasCategorias();
                $this->pages->render("Administrador/crearProducto", [
                    "categorias" => $categorias,
                    "errores" => $errores,
                    "old" => $_POST
                ]);
                return;
            }

            // Procesar la imagen
            if ($imagen && $imagen['error'] == UPLOAD_ERR_OK) {
                $imagenTmp = $imagen['tmp_name'];
                $imagenNombre = $imagen['name'];
                $rutaCarpeta = 'img/productos/';
                $rutaDestino = $rutaCarpeta . $imagenNombre;
                if (!is_dir($rutaCarpeta)) {
                    mkdir($rutaCarpeta, 0777, true);
                }
                $contador = 1;
                $rutaDestinoFinal = $rutaDestino;
                while (file_exists($rutaDestinoFinal)) {
                    $rutaDestinoFinal = $rutaCarpeta . pathinfo($imagenNombre, PATHINFO_FILENAME) . "_$contador." . pathinfo($imagenNombre, PATHINFO_EXTENSION);
                    $contador++;
                }
                if (move_uploaded_file($imagenTmp, $rutaDestinoFinal)) {
                    $imagen = basename($rutaDestinoFinal);
                } else {
                    $errores[] = 'Error al guardar la imagen.';
                }
            } else {
                $errores[] = 'Error al subir la imagen.';
            }
            if (!empty($errores)) {
                $categorias = $this->categoriaServices->obtenerTodasCategorias();
                $this->pages->render("Administrador/crearProducto", [
                    "categorias" => $categorias,
                    "errores" => $errores,
                    "old" => $_POST
                ]);
                return;
            }
            $this->productoServices->create($categoria_id, $nombre, $descripcion, $precio, $stock, $imagen);
            header('Location:' . BASE_URL . 'Administrador/gestionarProductos');
        } else {
            $categorias = $this->categoriaServices->obtenerTodasCategorias();
            $this->pages->render("Administrador/crearProducto", ["categorias" => $categorias]);
        }
    }

    // Método para editar un producto
    public function editarProducto()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $categoria_id = $_POST['nombre_categoria'];
            $stock = $_POST['stock'];
            $imagen = $_FILES['imagen'] ?? null;

            $errores = $this->validarProducto($nombre, $descripcion, $precio, $stock, $categoria_id, $imagen);
            $productoActual = $this->productoServices->getById($id);
            $imagenActual = $productoActual['imagen'];

            if (!empty($errores)) {
                $categorias = $this->categoriaServices->obtenerTodasCategorias();
                $producto = $productoActual;
                $this->pages->render("Administrador/editarProducto", [
                    "producto" => $producto,
                    "categorias" => $categorias,
                    "errores" => $errores,
                    "old" => $_POST
                ]);
                return;
            }

            if ($imagen && $imagen['error'] == UPLOAD_ERR_OK) {
                $imagenTmp = $imagen['tmp_name'];
                $imagenNombre = $imagen['name'];
                $rutaCarpeta = 'img/productos/';
                $rutaDestino = $rutaCarpeta . $imagenNombre;
                if (!is_dir($rutaCarpeta)) {
                    mkdir($rutaCarpeta, 0777, true);
                }
                $contador = 1;
                $rutaDestinoFinal = $rutaDestino;
                while (file_exists($rutaDestinoFinal)) {
                    $rutaDestinoFinal = $rutaCarpeta . pathinfo($imagenNombre, PATHINFO_FILENAME) . "_$contador." . pathinfo($imagenNombre, PATHINFO_EXTENSION);
                    $contador++;
                }
                if (move_uploaded_file($imagenTmp, $rutaDestinoFinal)) {
                    if (!empty($imagenActual) && file_exists($rutaCarpeta . $imagenActual)) {
                        unlink($rutaCarpeta . $imagenActual);
                    }
                    $imagenNombre = basename($rutaDestinoFinal);
                } else {
                    $errores[] = 'Error al guardar la nueva imagen.';
                }
            } else {
                $imagenNombre = $imagenActual;
            }
            if (!empty($errores)) {
                $categorias = $this->categoriaServices->obtenerTodasCategorias();
                $producto = $productoActual;
                $this->pages->render("Administrador/editarProducto", [
                    "producto" => $producto,
                    "categorias" => $categorias,
                    "errores" => $errores,
                    "old" => $_POST
                ]);
                return;
            }
            $this->productoServices->update($id, $nombre, $descripcion, $precio, $categoria_id, $imagenNombre, $stock);
            header('Location: ' . BASE_URL . 'Administrador/gestionarProductos');
            exit();
        } else {
            $id = $_GET['id'];
            $producto = $this->productoServices->getById($id);
            $categorias = $this->categoriaServices->obtenerTodasCategorias();
            $this->pages->render("Administrador/editarProducto", ["producto" => $producto, "categorias" => $categorias]);
        }
    }


    // Método para eliminar un producto
    public function eliminarProducto($id)
    {
        $this->productoServices->delete($id);
        header('Location:' . BASE_URL . 'Administrador/gestionarProductos');
    }

    // Obtener productos al azar
    public function obtenerProductosAlAzar()
    {
        $productos = $this->productoServices->obtenerProductosAlAzar();
        return $productos;
    }

    // Método para ver un producto
    public function verProducto($id)
    {
        $producto = $this->productoServices->getById($id);
        $this->pages->render("Producto/verProducto", ["producto" => $producto]);
    }

    // Método para validar los datos de producto (crear o editar)
    private function validarProducto($nombre, $descripcion, $precio, $stock, $categoria_id, $imagen = null) {
        $errores = [];
        if (empty($nombre) || strlen($nombre) < 3) {
            $errores[] = 'El nombre es obligatorio y debe tener al menos 3 caracteres.';
        }
        if (empty($descripcion) || strlen($descripcion) < 10) {
            $errores[] = 'La descripción es obligatoria y debe tener al menos 10 caracteres.';
        }
        if (!is_numeric($precio) || $precio <= 0) {
            $errores[] = 'El precio debe ser un número mayor que 0.';
        }
        if (!is_numeric($stock) || $stock < 0) {
            $errores[] = 'El stock debe ser un número igual o mayor que 0.';
        }
        if (empty($categoria_id) || !is_numeric($categoria_id)) {
            $errores[] = 'La categoría es obligatoria.';
        }
        if ($imagen && isset($imagen['name']) && $imagen['name'] !== '') {
            $permitidas = ['image/jpeg', 'image/png', 'image/webp'];
            if (!in_array($imagen['type'], $permitidas)) {
                $errores[] = 'La imagen debe ser JPG, PNG o WEBP.';
            }
        }
        return $errores;
    }
}

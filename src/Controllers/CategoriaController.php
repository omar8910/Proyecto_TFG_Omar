<?php

namespace Controllers;

use Services\CategoriaServices;
use Repositories\CategoriaRepository;
use Services\ProductoServices;
use Repositories\ProductoRepository;
use Models\Categoria;

use Lib\Pages;

class CategoriaController
{
    // Atributos
    private CategoriaServices $categoriaServices;
    private ProductoServices $productoServices;
    private Pages $pages;

    // Constructor
    public function __construct()
    {
        $this->categoriaServices = new CategoriaServices(new CategoriaRepository());
        $this->productoServices = new ProductoServices(new ProductoRepository());
        $this->pages = new Pages();
    }

    // Método para obtener todas las categorías
    public function obtenerTodasCategorias()
    {
        return $this->categoriaServices->obtenerTodasCategorias();
    }

    // Método para crear una categoria
    public function crearCategoria()
    {
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $categoria = new Categoria($nombre);
            $categoria->setNombre($nombre);
            $this->categoriaServices->create($categoria);
            header('Location:' . BASE_URL . 'Administrador/gestionarCategorias');
        } else {
            $this->pages->render('Administrador/crearCategoria');
        }
    }

    // Método para gestionar las categorías
    public function gestionarCategorias()
    {
        $categorias = $this->categoriaServices->obtenerTodasCategorias();
        $this->pages->render('Administrador/gestionarCategorias', ['categorias' => $categorias]);
    }


    // Método para eliminar una categoria
    public function eliminarCategoria($id)
    {
        $this->categoriaServices->delete($id);
        $this->gestionarCategorias();
    }

    public function editarCategoria()
    {
        $categorias = $this->categoriaServices->obtenerTodasCategorias();
        $this->pages->render('Administrador/gestionarCategorias', ['categorias' => $categorias]);
    }

    // Método para editar una categoria
    public function actualizarCategoria()
    {
        if (isset($_POST['datos'])) {
            $datos = $_POST['datos'];
            $id = $datos['id'];
            $nombre = $datos['nombre'];
            $this->categoriaServices->update($id, $nombre);
            $this->gestionarCategorias();
        }
    }

    // Método para ver una categoria
    public function verCategoria($id)
    {
        $categoria_id = $id;
        $categoria = $this->categoriaServices->getById($categoria_id);
        $productos = $this->productoServices->getByCategoria($categoria_id);
        $menu = $this->obtenerTodasCategorias();

        $this->pages->render('Categoria/verCategoria', ['productos' => $productos, 'categoria' => $categoria, 'menu' => $menu]);
    }
}

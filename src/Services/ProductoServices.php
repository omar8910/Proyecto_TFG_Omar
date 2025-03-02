<?php
namespace Services;
use Repositories\ProductoRepository;

class ProductoServices{
    private ProductoRepository $productoRepository;

    public function __construct(ProductoRepository $productoRepository){
        $this->productoRepository = $productoRepository;
    }

    public function create($categoria_id, $nombre, $descripcion, $precio, $stock, $imagen){
        return $this->productoRepository->create($categoria_id, $nombre, $descripcion, $precio, $stock, $imagen);
    }

    public function update($id, $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock){
        return $this->productoRepository->update($id, $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock);
    }

    public function delete($id){
        return $this->productoRepository->delete($id);
    }

    public function getById($id){
        return $this->productoRepository->getById($id);
    }

    public function getByCategoria($categoria_id){
        return $this->productoRepository->getByCategoria($categoria_id);
    }

    public function obtenerTodosProductos(){
        return $this->productoRepository->obtenerTodosProductos();
    }

    public function obtenerProductosAlAzar(){
        return $this->productoRepository->obtenerProductosAlAzar();
    }
    
}
?>
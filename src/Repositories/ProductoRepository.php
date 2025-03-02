<?php

namespace Repositories;

use Lib\BaseDatos;
use PDO;
use PDOException;

class ProductoRepository
{
    private BaseDatos $BaseDatos;

    //Constructor
    public function __construct()
    {
        $this->BaseDatos = new BaseDatos();
    }


    // Método para obtener todos los productos
    public function obtenerTodosProductos()
    {
        $this->BaseDatos->consulta("SELECT * FROM productos order by categoria_id");
        $this->BaseDatos->close();
        return $this->BaseDatos->extraer_todos();
    }

    // Método para obtener un producto por su id
    public function getById($id)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM productos WHERE id = :id");
            $sel->bindParam(":id", $id, PDO::PARAM_INT);
            $sel->execute();
            $producto = $sel->fetch(PDO::FETCH_ASSOC); // Devuelve un array con el registro
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($sel) {
                $sel->closeCursor();
                $sel = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return $producto;
    }

    // Método para obtener los productos segun su categoria
    public function getByCategoria($categoria_id)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM productos WHERE categoria_id = :categoria_id");
            $sel->bindParam(":categoria_id", $categoria_id, PDO::PARAM_INT);
            $sel->execute();
            $productos = $sel->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array con el registro
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($sel) {
                $sel->closeCursor();
                $sel = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return $productos;
    }

    // Método para crear un producto
    public function create($categoria_id, $nombre, $descripcion, $precio, $stock, $imagen): bool
    {
        try {
            // Preparamos la consulta
            $ins = $this->BaseDatos->prepara("INSERT INTO
             productos(categoria_id, nombre, descripcion, precio, stock, imagen)
             VALUES (:categoria_id, :nombre, :descripcion, :precio, :stock, :imagen)");

            // Vinculamos las variables
            $ins->bindParam(":categoria_id", $categoria_id, PDO::PARAM_INT);
            $ins->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $ins->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $ins->bindParam(":precio", $precio, PDO::PARAM_STR);
            $ins->bindParam(":stock", $stock, PDO::PARAM_INT);
            $ins->bindParam(":imagen", $imagen, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $ins->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al crear el producto: " . $e->getMessage();
        } finally {
            if ($ins) {
                // Cerramos consulta
                $ins->closeCursor();
                $ins = null;
            }
        }
        // Cerramos la conexion
        $this->BaseDatos->close();
        return $success;
    }

    public function delete($id)
    {
        try {
            // Preparamos la consulta
            $del = $this->BaseDatos->prepara("DELETE FROM productos WHERE id = :id");

            // Vinculamos las variables
            $del->bindParam(":id", $id, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $del->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al eliminar el producto: " . $e->getMessage();
        } finally {
            if ($del) {
                // Cerramos consulta
                $del->closeCursor();
                $del = null;
            }
        }
        // Cerramos la conexion
        // $this->BaseDatos->close();
        return $success;
    }

    public function update($id, $nombre, $descripcion, $precio, $categoria_id, $imagen, $stock)
    {
        try {
            // Preparamos la consulta
            $upd = $this->BaseDatos->prepara("UPDATE productos SET nombre = :nombre, descripcion = :descripcion, precio = :precio, categoria_id = :categoria_id, imagen = :imagen, stock = :stock WHERE id = :id");

            // Vinculamos las variables
            $upd->bindParam(":id", $id, PDO::PARAM_INT);
            $upd->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $upd->bindParam(":descripcion", $descripcion, PDO::PARAM_STR);
            $upd->bindParam(":precio", $precio, PDO::PARAM_STR);
            $upd->bindParam(":categoria_id", $categoria_id, PDO::PARAM_INT);
            $upd->bindParam(":imagen", $imagen, PDO::PARAM_STR);
            $upd->bindParam(":stock", $stock, PDO::PARAM_INT);
            

            // Ejecutamos la consulta
            $upd->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al actualizar el producto: " . $e->getMessage();
        } finally {
            if ($upd) {
                // Cerramos consulta
                $upd->closeCursor();
                $upd = null;
            }
        }
        // Cerramos la conexion
        // $this->BaseDatos->close();
        return $success;
    }

    // Método para obtener productos al azar
    public function obtenerProductosAlAzar()
    {
        $this->BaseDatos->consulta("SELECT * FROM productos ORDER BY RAND() LIMIT 6");
        $this->BaseDatos->close();
        return $this->BaseDatos->extraer_todos();
    }
}
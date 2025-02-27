<?php

namespace Repositories;

use Lib\BaseDatos;
use PDO;
use PDOException;

class CategoriaRepository
{
    private BaseDatos $BaseDatos;

    // Constructor con la conexión a la base de datos
    public function __construct()
    {
        $this->BaseDatos = new BaseDatos();
    }

    // Método para crear una nueva categoría
    public function create($categoria): bool
    {
        // $id = $categoria->getId(); // No es necesario porque el id es autoincremental
        $nombre = $categoria->getNombre();

        try {
            // Preparamos la consulta. Usamos marcadores con nombres para evitar inyección SQL
            // El valor del id lo pongo a null porque en la base de datos es autoincremental
            $ins = $this->BaseDatos->prepara("INSERT INTO categorias(id,nombre) VALUES (null,:nombre)");


            // Vinculamos las variables, como son muchos campos, usamos bindParam
            // $ins->bindParam(":id", $id, PDO::PARAM_INT); // No es necesario porque el id es autoincremental
            $ins->bindParam(":nombre", $nombre, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $ins->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al crear la categoría: " . $e->getMessage();
        } finally {
            // Cerramos la consulta
            if ($ins) {
                // Hacemos esta comprobación para evitar errores si ins es null
                $ins->closeCursor();
                $ins = null;
            }
        }
        // $this->BaseDatos->close();
        return $success;
    }

    // Método para actualizar una categoria
    public function update($id, $nombre): bool
    {
        try {
            // Preparamos la consulta. Usamos marcadores con nombres para evitar inyección SQL
            $upd = $this->BaseDatos->prepara("UPDATE categorias SET nombre = :nombre WHERE id = :id");

            // Vinculamos las variables, como son muchos campos, usamos bindParam
            $upd->bindParam(":id", $id, PDO::PARAM_INT);
            $upd->bindParam(":nombre", $nombre, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $upd->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al actualizar la categoría: " . $e->getMessage();
        } finally {
            // Cerramos la consulta
            if ($upd) {
                // Hacemos esta comprobación para evitar errores si ins es null
                $upd->closeCursor();
                $upd = null;
            }
        }
        // $this->BaseDatos->close();
        return $success;
    }

    // Método para eliminar una categoría
    public function delete($id): bool
    {
        try {
            // Preparamos la consulta. Usamos marcadores con nombres para evitar inyección SQL
            $del = $this->BaseDatos->prepara("DELETE FROM categorias WHERE id = :id");

            // Vinculamos las variables, como son muchos campos, usamos bindParam
            $del->bindParam(":id", $id, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $del->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al eliminar la categoría: " . $e->getMessage();
        } finally {
            // Cerramos la consulta
            if ($del) {
                // Hacemos esta comprobación para evitar errores si ins es null
                $del->closeCursor();
                $del = null;
            }
        }
        // Cerramos la conexión
        // $this->BaseDatos->close(); EL PROBLEMA ERA EL CIERRE si me sale query() null.
        return $success;
    }

    // Método para obtener todas las categorías
    public function obtenerTodasCategorias()
    {
        $this->BaseDatos->consulta("SELECT * FROM categorias");
        $this->BaseDatos->close();
        return $this->BaseDatos->extraer_todos();
    }

    // Método para obtener una categoría por su id
    public function getById($id)
    {
        try {
            // Preparamos la consulta. Usamos marcadores con nombres para evitar inyección SQL
            $sel = $this->BaseDatos->prepara("SELECT * FROM categorias WHERE id = :id");

            // Vinculamos las variables, como son muchos campos, usamos bindParam
            $sel->bindParam(":id", $id, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $sel->execute();
            $categoria = $sel->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error al obtener la categoría: " . $e->getMessage();
            return false;
        } finally {
            // Cerramos la consulta
            if ($sel) {
                // Hacemos esta comprobación para evitar errores si ins es null
                $sel->closeCursor();
                $sel = null;
            }
        }
        // Cerramos la conexión
        // $this->BaseDatos->close();
        return $categoria;
    }
}

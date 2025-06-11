<?php

namespace Repositories;

use Lib\BaseDatos;

class CarritoRepository
{
    private BaseDatos $db;

    public function __construct()
    {
        $this->db = new BaseDatos();
    }

    public function guardarProducto($usuarioId, $productoId, $cantidad)
    {
        $sql = "INSERT INTO carritos (usuario_id, producto_id, cantidad)
                VALUES (:usuario_id, :producto_id, :cantidad)
                ON DUPLICATE KEY UPDATE cantidad = :cantidad";
        $stmt = $this->db->prepara($sql);
        $stmt->bindValue(":usuario_id", $usuarioId);
        $stmt->bindValue(":producto_id", $productoId);
        $stmt->bindValue(":cantidad", $cantidad);
        return $stmt->execute();
    }

    public function obtenerCarrito($usuarioId)
    {
        $sql = "SELECT producto_id, cantidad FROM carritos WHERE usuario_id = :usuario_id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindValue(":usuario_id", $usuarioId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function eliminarProducto($usuarioId, $productoId)
    {
        $sql = "DELETE FROM carritos WHERE usuario_id = :usuario_id AND producto_id = :producto_id";
        $stmt = $this->db->prepara($sql);
        $stmt->bindValue(":usuario_id", $usuarioId);
        $stmt->bindValue(":producto_id", $productoId);
        return $stmt->execute();
    }

    // Guarda el carrito completo para un usuario (sobrescribe el anterior)
    public function guardarCarrito($usuarioId, $carrito)
    {
        // 1. Elimina todos los productos del usuario en la tabla carritos
        $sqlDelete = "DELETE FROM carritos WHERE usuario_id = :usuario_id";
        $stmtDelete = $this->db->prepara($sqlDelete);
        $stmtDelete->bindValue(":usuario_id", $usuarioId);
        $stmtDelete->execute();

        // 2. Inserta los productos actuales del carrito
        foreach ($carrito as $producto) {
            $sqlInsert = "INSERT INTO carritos (usuario_id, producto_id, cantidad) VALUES (:usuario_id, :producto_id, :cantidad)";
            $stmtInsert = $this->db->prepara($sqlInsert);
            $stmtInsert->bindValue(":usuario_id", $usuarioId);
            $stmtInsert->bindValue(":producto_id", $producto['id']);
            $stmtInsert->bindValue(":cantidad", $producto['cantidad']);
            $stmtInsert->execute();
        }
    }
}

?>

<?php

namespace Repositories;

use Lib\BaseDatos;
use Lib\Pages;
use PDO;
use PDOException;

class PedidoRepository
{
    private BaseDatos $BaseDatos;
    private Pages $pages;


    public function __construct()
    {
        $this->BaseDatos = new BaseDatos();
        $this->pages = new Pages();
    }

    public function obtenerTodosPedidos()
    {
        $consultaSQL = "SELECT * FROM pedidos ORDER BY id DESC";
        $this->BaseDatos->consulta($consultaSQL);
        // $this->BaseDatos->close();
        return $this->BaseDatos->extraer_todos();
    }

    public function getById($id)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM pedidos WHERE id = :id");
            $sel->bindParam(":id", $id, PDO::PARAM_INT);
            $sel->execute();
            $pedido = $sel->fetch(PDO::FETCH_ASSOC); // Devuelve un array con el registro
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
        return $pedido;
    }

    public function getByUsuario($usuario_id)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM pedidos WHERE usuario_id = :usuario_id");
            $sel->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $sel->execute();
            $pedidos = $sel->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array con el registro
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
        return $pedidos;
    }

    public function delete($id)
    {
        try {
            $del = $this->BaseDatos->prepara("DELETE FROM lineas_pedidos WHERE pedido_id = :id");
            $del->bindParam(":id", $id, PDO::PARAM_INT);
            $del->execute();
            $del2 = $this->BaseDatos->prepara("DELETE FROM pedidos WHERE id = :id");
            $del2->bindParam(":id", $id, PDO::PARAM_INT);
            $del2->execute();
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($del) {
                $del->closeCursor();
                $del = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return $del;
    }

    // Método para actualizar un pedido
    public function update($id, $fecha, $hora, $coste, $estado, $usuario_id)
    {
        try {
            $upd = $this->BaseDatos->prepara("UPDATE pedidos SET fecha = :fecha, hora = :hora, coste = :coste, estado = :estado, usuario_id = :usuario_id WHERE id = :id");
            $upd->bindParam(":id", $id, PDO::PARAM_INT);
            $upd->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $upd->bindParam(":hora", $hora, PDO::PARAM_STR);
            $upd->bindParam(":coste", $coste, PDO::PARAM_STR);
            $upd->bindParam(":estado", $estado, PDO::PARAM_STR);
            $upd->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $upd->execute();
            $success = true;
        } catch (PDOException $error) {
            $success = false;
            echo ("Error al actualizar el pedido: " . $error->getMessage());
        } finally {
            // Cerramos la consulta
            if ($upd) {
                $upd->closeCursor();
                $upd = null;
            }
        }
        // Cerramos la conexión
        // $this->BaseDatos->close();
        return $upd;
    }

    public function getProductosPedido($pedido_id)
    {
        try {
            $sel = $this->BaseDatos->prepara(
                "SELECT productos.id, productos.nombre, productos.precio, lineas_pedidos.unidades
                FROM lineas_pedidos 
                INNER JOIN productos ON lineas_pedidos.producto_id = productos.id 
                WHERE lineas_pedidos.pedido_id = :pedido_id"
            );
            $sel->bindParam(":pedido_id", $pedido_id, PDO::PARAM_INT);
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

    public function getCantidadProducto($pedido_id, $producto_id)
    {
        try {
            $sel = $this->BaseDatos->prepara(
                "SELECT cantidad 
                FROM lineas_pedidos 
                WHERE pedido_id = :pedido_id AND producto_id = :producto_id"
            );
            $sel->bindParam(":pedido_id", $pedido_id, PDO::PARAM_INT);
            $sel->bindParam(":producto_id", $producto_id, PDO::PARAM_INT);
            $sel->execute();
            $cantidad = $sel->fetch(PDO::FETCH_ASSOC); // Devuelve un array con el registro
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
        return $cantidad;
    }

    public function calcularTotal($carrito)
    {
        $total = 0;
        foreach ($carrito as $producto) {
            $total += $producto['precio'] * $producto['cantidad'];
        }
        return $total;
    }

    public function guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora)
    {
        try {
            $ins = $this->BaseDatos->prepara("INSERT INTO pedidos (usuario_id, provincia, localidad, direccion, coste, estado, fecha, hora) VALUES (:usuario_id, :provincia, :localidad, :direccion, :coste, :estado, :fecha, :hora)");
            $ins->bindParam(":usuario_id", $usuario_id, PDO::PARAM_INT);
            $ins->bindParam(":provincia", $provincia, PDO::PARAM_STR);
            $ins->bindParam(":localidad", $localidad, PDO::PARAM_STR);
            $ins->bindParam(":direccion", $direccion, PDO::PARAM_STR);
            $ins->bindParam(":coste", $coste, PDO::PARAM_STR);
            $ins->bindParam(":estado", $estado, PDO::PARAM_STR);
            $ins->bindParam(":fecha", $fecha, PDO::PARAM_STR);
            $ins->bindParam(":hora", $hora, PDO::PARAM_STR);
            $ins->execute();
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($ins) {
                $ins->closeCursor();
                $ins = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();

        // Devolvemos el id del pedido insertado
        return $this->BaseDatos->lastInsertId();
    }

    public function guardarLineaPedido($pedido_id, $carrito)
    {
        try {
            foreach ($carrito as $producto) {
                // die(var_dump($producto));
                $producto_id = $producto['id'];
                $unidades = $producto['cantidad'];
                $ins = $this->BaseDatos->prepara("INSERT INTO lineas_pedidos (pedido_id, producto_id, unidades) VALUES (:pedido_id, :producto_id, :unidades)");
                $ins->bindParam(":pedido_id", $pedido_id, PDO::PARAM_INT);
                $ins->bindParam(":producto_id", $producto_id, PDO::PARAM_INT);
                $ins->bindParam(":unidades", $unidades, PDO::PARAM_INT);
                $ins->execute();
                $this->reduceStock($producto_id, $unidades);
            }
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($ins) {
                $ins->closeCursor();
                $ins = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return true;
    }

    public function create($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora, $carrito)
    {
        $hayStock = $this->comprobarSiHayStock($carrito);
        if (!$hayStock) {
            return " No hay stock suficiente para realizar el pedido. Por favor, revise el carrito.";
        }
        $this->BaseDatos->empezarTransaccion();
        try {
            $pedido_id = $this->guardarPedido($usuario_id, $provincia, $localidad, $direccion, $coste, $estado, $fecha, $hora);
            $this->guardarLineaPedido($pedido_id, $carrito);
            $this->BaseDatos->confirmarTransaccion();
            return true;
        } catch (PDOException $error) {
            $this->BaseDatos->cancelarTransaccion();
            echo ("Error en la consulta: " . $error->getMessage());
            return "Error al realizar el pedido. Por favor, inténtelo de nuevo.";
        }
    }

    public function updateEstado($id_pedido)
    {
        $estado = "confirmado";
        try {
            $upd = $this->BaseDatos->prepara("UPDATE pedidos SET estado = :estado WHERE id = :id");
            $upd->bindParam(":id", $id_pedido, PDO::PARAM_INT);
            $upd->bindParam(":estado", $estado, PDO::PARAM_STR);
            $upd->execute();
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($upd) {
                $upd->closeCursor();
                $upd = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return $upd;
    }

    public function getLastId()
    {
        return $this->BaseDatos->lastInsertId();
    }

    public function reduceStock($producto_id, $unidades)
    {
        try {
            $upd = $this->BaseDatos->prepara("UPDATE productos SET stock = stock - :unidades WHERE id = :producto_id");
            $upd->bindParam(":producto_id", $producto_id, PDO::PARAM_INT);
            $upd->bindParam(":unidades", $unidades, PDO::PARAM_INT);
            $upd->execute();
        } catch (PDOException $error) {
            echo ("Error en la consulta: " . $error->getMessage());
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($upd) {
                $upd->closeCursor();
                $upd = null;
            }
        }
        // Cerramos la conexión a la base de datos
        // $this->BaseDatos->close();
        return $upd;
    }

    public function comprobarSiHayStock($carrito)
    {
        $hayStock = true;
        foreach ($carrito as $producto) {
            $producto_id = $producto['id'];
            $unidades = $producto['cantidad'];
            $sel = $this->BaseDatos->prepara("SELECT stock FROM productos WHERE id = :producto_id");
            $sel->bindParam(":producto_id", $producto_id, PDO::PARAM_INT);
            $sel->execute();
            $stock = $sel->fetch(PDO::FETCH_ASSOC);
            if ($stock['stock'] < $unidades) {
                $hayStock = false;
                break;
            }
        }
        return $hayStock;
    }
}

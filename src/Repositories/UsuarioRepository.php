<?php
/*
La carpeta Repository contiene clases que se encargan de la interacción con la base de datos. 

Cada clase en la carpeta Repository representa una tabla en la base de datos y contiene métodos 
para realizar operaciones CRUD (Crear, Leer, Actualizar, Eliminar) en esa tabla.

Por ejemplo, la clase UsuarioRepository contiene métodos para interactuar con la tabla de usuarios en la base de datos. Tiene métodos: 
como create() para crear un nuevo usuario, 
getById() para obtener un usuario por su ID,
update() para actualizar los datos de un usuario, 
y delete() para eliminar un usuario.

Estos repositorios son utilizados por las clases en la carpeta Services. Los servicios utilizan los métodos de los repositorios para interactuar con la base de datos y realizar operaciones CRUD en las tablas.
*/

namespace Repositories;

use Lib\BaseDatos;
use PDO;
use PDOException;

class UsuarioRepository
{
    private BaseDatos $BaseDatos;

    // Constructor con la conexión a la base de datos
    public function __construct()
    {
        $this->BaseDatos = new BaseDatos();
    }

    // Método para crear un nuevo usuario
    public function create($usuario): bool
    {
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();

        if (isset($_POST['datos']['rol'])) {
            $usuario->setRol($_POST['datos']['rol']);
        } else {
            $usuario->setRol('usuario');
        }
        $rol = $usuario->getRol();


        try {
            // Preparamos la consulta. Usamos marcadores con nombres para evitar inyección SQL
            $ins = $this->BaseDatos->prepara("INSERT INTO usuarios(id,nombre, apellidos, email, password, rol) VALUES (:id,:nombre, :apellidos, :email, :password, :rol)");

            // Vinculamos las variables, como son muchos campos, usamos bindParam
            $ins->bindParam(":id", $id, PDO::PARAM_INT);
            $ins->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $ins->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
            $ins->bindParam(":email", $email, PDO::PARAM_STR);
            $ins->bindParam(":password", $password, PDO::PARAM_STR);
            $ins->bindParam(":rol", $rol, PDO::PARAM_STR);

            // Ejecutamos la consulta
            $ins->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo "Error al crear el usuario: " . $e->getMessage();
        }
        // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
        finally {
            // Cerramos la consulta
            if ($ins) {
                // Hacemos esta comprobación para evitar errores si ins es null
                $ins->closeCursor();
                $ins = null;
            }
        }
        // Cerramos la conexión
        $this->BaseDatos->close();
        return $success;
    }

    // Método para obtener todos los usuarios
    public function obtenerTodosUsuarios()
    {
        // Como no tenemos que pasar marcadores pues no necesitamos preparar la consulta
        $this->BaseDatos->consulta("SELECT * FROM usuarios");
        $this->BaseDatos->close();
        return $this->BaseDatos->extraer_todos(); // Devuelve un array con todos los registros
    }

    // Método para obtener un usuario por su ID
    public function getById($id)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM usuarios WHERE id = :id");
            $sel->bindParam(":id", $id, PDO::PARAM_INT);
            $sel->execute();
            $usuario = $sel->fetch(PDO::FETCH_ASSOC); // Devuelve un array con el registro
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
        // $this->BaseDatos = null;
        $this->BaseDatos->close();
        return $usuario;
    }

    // Método para buscar un usuario por su email
    public function getByEmail($email)
    {
        try {
            $sel = $this->BaseDatos->prepara("SELECT * FROM usuarios WHERE email=:email LIMIT 1");
            $sel->bindValue(':email', $email, PDO::PARAM_STR);
            $sel->execute();
            $usuario = $sel->fetch(PDO::FETCH_OBJ);
            return $usuario !== false ? $usuario : null;
        } catch (PDOException $error) {
            echo "Error al buscar el email: " . $error->getMessage();
            return false;
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($sel) {
                // Hacemos esta comprobación para evitar errores si sel es null
                $sel->closeCursor();
                $sel = null;
            }
        }
        // Cerramos la conexión a la base de datos
        $this->BaseDatos->close();
    }

    // Método para iniciar sesión
    public function iniciarSesion($usuario)
    {
        $email = $usuario->getEmail();
        $password = $usuario->getPassword();

        try {
            $datosUsuario = $this->getByEmail($email);

            if ($datosUsuario && password_verify($password, $datosUsuario->password)) {
                return $datosUsuario;
            }
        } catch (PDOException $error) {
            echo "Error al iniciar sesión: " . $error->getMessage();
        }

        return false;
    }


    // Método para actualizar los datos de un usuario
    public function update($usuario)
    {
        // var_dump($usuario);
        $id = $usuario->getId();
        $nombre = $usuario->getNombre();
        $apellidos = $usuario->getApellidos();
        $email = $usuario->getEmail();
        $rol = $usuario->getRol();
        // No se actualiza la contraseña

        try {
            // Preparamos la consulta
            $upd = $this->BaseDatos->prepara("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, rol = :rol WHERE id = :id");

            // Vinculamos las variables
            $upd->bindParam(":id", $id, PDO::PARAM_INT);
            $upd->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $upd->bindParam(":apellidos", $apellidos, PDO::PARAM_STR);
            $upd->bindParam(":email", $email, PDO::PARAM_STR);
            $upd->bindParam(":rol", $rol, PDO::PARAM_STR);


            // Ejecutamos la consulta
            $upd->execute();
            $success = true;
        } catch (PDOException $error) {
            $success = false;
            echo ("Error al actualizar el usuario: " . $error->getMessage());
        } finally {
            if ($upd) {
                $upd->closeCursor();
                $upd = null;
            }
        }
        $this->BaseDatos->close();
        return $success;
    }


    // Método para eliminar un usuario
    public function delete($id)
    {
        try {
            // Preparamos la consulta
            $del = $this->BaseDatos->prepara("DELETE FROM usuarios WHERE id = :id");

            // Vinculamos las variables
            $del->bindParam(":id", $id, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $del->execute();
            $success = true;
        } catch (PDOException $e) {
            $success = false;
            echo ("Error al eliminar el usuario: " . $e->getMessage());
        } finally {
            // Este bloque se ejecuta siempre, independientemente de si se ha producido una excepción o no
            // así liberamos los recursos utilizados.
            // Cerramos la consulta
            if ($del) {
                // Hacemos esta comprobación para evitar errores si del es null
                $del->closeCursor();
                $del = null;
            }
        }
        // Cerramos la conexión
        $this->BaseDatos->close();
        return $success;
    }
}

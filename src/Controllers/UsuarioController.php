<?php

namespace Controllers;

use Models\Usuario;
use Services\UsuarioServices;
use Repositories\UsuarioRepository;


use Lib\Pages;
use Utils\Utils;
use Exception;


class UsuarioController
{
    // Atributos
    private Pages $pages;
    private UsuarioServices $usuarioServices;
    private $mensajesError = [];

    // Constructor
    public function __construct()
    {
        $this->pages = new Pages();
        $this->usuarioServices = new UsuarioServices(new UsuarioRepository);
    }

    // Método para ver los usuarios
    public function obtenerTodosUsuarios()
    {
        $usuarios = $this->usuarioServices->obtenerTodosUsuarios();
        $this->pages->render('Administrador/mostrarUsuarios', ['usuarios' => $usuarios]);
    }

    // Validación y saneamiento de formularios
    private function validarFormulario($datos)
    {
        // Verificar si la clave 'rol' está definida en $datos
        $rol = isset($datos['rol']) ? filter_var($datos['rol'], FILTER_SANITIZE_STRING) : 'usuario';

        // Saneamiento de datos
        $nombre = filter_var($datos['nombre'], FILTER_SANITIZE_STRING);
        $apellidos = filter_var($datos['apellidos'], FILTER_SANITIZE_STRING);
        $email = filter_var($datos['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($datos['password'], FILTER_SANITIZE_STRING);

        // Validación con expresiones regulares (patrones)
        $patronNombre = "/^[a-zA-ZáéíóúÁÉÍÓÚ '-]*$/";  // Solo letras y espacios y apóstrofes
        $patronApellido = "/^[a-zA-ZáéíóúÁÉÍÓÚ '-]*$/";  // Solo letras, espacios, apóstrofes y guiones
        $patronCorreo = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Formato de correo electrónico
        $patronPassword = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/"; //  Al menos una letra y un número, mínimo 6 caracteres

        if (empty($nombre) || !preg_match($patronNombre, $nombre)) {
            throw new Exception('El nombre solo debe contener letras, espacios y apóstrofes.');
        }
        if (empty($apellidos) || !preg_match($patronApellido, $apellidos)) {
            throw new Exception('Los apellidos solo deben contener letras, espacios, apóstrofes y guiones.');
        }
        if (empty($email) || !preg_match($patronCorreo, $email)) {
            throw new Exception('El correo electrónico debe seguir el formato example@example.com.');
        }
        if (empty($password) || !preg_match($patronPassword, $password)) {
            throw new Exception('La contraseña debe tener al menos una letra, un número y un mínimo de 6 caracteres.');
        }

        return [
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'password' => $this->encriptarPassword($password),
            'rol' => $rol
        ];
    }

    // Método para encriptar la contraseña
    private function encriptarPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }


    // Método para registrar un usuario
    public function registrarUsuario()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $datos = $this->validarFormulario($_POST['datos']);
                // die(var_dump($datos));

                if ($datos !== null) {
                    $usuario = Usuario::fromArray($datos);
                    // die(var_dump($usuario));
                    $usuarioCreado = $this->usuarioServices->create($usuario);
                    // die(var_dump($usuarioCreado));
                    if ($usuarioCreado) {
                        // die(var_dump($usuarioCreado));
                        $_SESSION['registro'] = 'correcto';

                        // Verificar si el usuario actual es un administrador
                        if (isset($_SESSION['inicioSesion']) && $_SESSION['inicioSesion']->rol === 'administrador') {
                            // Redirigir al panel de administración de usuarios
                            header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
                        } else {
                            // Redirigir a la página de inicio de sesión (comportamiento actual)
                            header('Location: ' . BASE_URL . 'Usuario/registrarUsuarios');
                        }
                        exit();
                    } else {
                        $_SESSION['registro'] = 'incorrecto';
                        throw new Exception('Error al registrar el usuario');
                    }
                } else {
                    $_SESSION['registro'] = 'incorrecto';
                    throw new Exception('Los datos del formulario están vacíos');
                }
            } else {
                $this->pages->render('Usuario/registrarUsuarios');
            }
        } catch (Exception $e) {
            $_SESSION['registro'] = 'incorrecto';
            $this->mensajesError[] = $e->getMessage();
            $this->pages->render('Usuario/registrarUsuarios', ['mensajesError' => $this->mensajesError]);
        }
    }

    // Método para validar el inicio de sesión
    private function validarInicioSesion($datos)
    {
        $email = filter_var($datos['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($datos['password'], FILTER_SANITIZE_STRING);

        $patronCorreo = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Formato de correo electrónico
        $patronPassword = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/"; //  Al menos una letra y un número, mínimo 6 caracteres

        if (empty($email) || !preg_match($patronCorreo, $email)) {
            throw new Exception('El correo electrónico debe seguir el formato example@example.com.');
        }
        if (empty($password) || !preg_match($patronPassword, $password)) {
            throw new Exception('La contraseña debe tener al menos una letra, un número y un mínimo de 6 caracteres.');
        }

        return [
            'email' => $email,
            'password' => $password
        ];
    }

    // Método para  iniciar sesión
    public function iniciarSesion()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $datos = $this->validarInicioSesion($_POST['datos']);
                if ($datos !== null) {
                    $usuario = Usuario::fromArray($datos);
                    $verificarUsuario = $this->usuarioServices->iniciarSesion($usuario);
                    if ($verificarUsuario) {
                        $_SESSION['inicioSesion'] = $verificarUsuario; // Guardamos el usuario en la sesión para tener acceso a sus datos
                        // die(var_dump($_SESSION['inicioSesion']->email));

                        // Si el usuario seleccionó "Recordar usuario", guardamos su correo en una cookie con duración de 7 días
                        if (isset($_POST['remember'])) {
                            // Guardar un estado de sesion para saber que eligió recordar usuario
                            $_SESSION['recordarUsuario'] = true;

                            // Crear cookie válida por 7 días
                            // setcookie('usuario', $_SESSION['inicioSesion']->email, time() + (7 * 24 * 60 * 60), "/"); // Expira en 7 días
                            // Valida para un minuto para probar
                            setcookie('usuario', $_SESSION['inicioSesion']->email, time() + (1 * 60), "/"); // Expira en 1 minuto
                        } else {
                            $_SESSION['recordarUsuario'] = false; // No recordar
                        }

                        header('Location: ' . BASE_URL);
                    } else {
                        $_SESSION['inicioSesion'] = 'incorrecto';
                        throw new Exception('Usuario o contraseña incorrectos');
                    }
                } else {
                    $_SESSION['inicioSesion'] = 'incorrecto';
                    throw new Exception('Los datos del formulario están vacíos');
                }
            } else {
                $this->pages->render('Usuario/iniciarSesion');
            }
        } catch (Exception $e) {
            $_SESSION['inicioSesion'] = 'incorrecto';
            $this->mensajesError[] = $e->getMessage();
            $this->pages->render('Usuario/iniciarSesion', ['mensajesError' => $this->mensajesError]);
        }
    }

    // Método para editar un usuario
    public function editarUsuario($id)
    {
        $usuarios = $this->usuarioServices->obtenerTodosUsuarios();
        $this->pages->render('Administrador/mostrarUsuarios', ['usuarios' => $usuarios, 'id' => $id]);
    }

    // Método para validar la edición de un usuario
    private function validarEdicionUsuario($datos)
    {
        // Verificar que los datos no estén vacíos
        if (empty($datos['nombre']) || empty($datos['apellidos']) || empty($datos['email']) || empty($datos['rol'])) {
            throw new Exception('Todos los campos son obligatorios.');
        }

        // Saneamiento de datos
        $id = filter_var($datos['id'], FILTER_SANITIZE_NUMBER_INT);
        $nombre = filter_var($datos['nombre'], FILTER_SANITIZE_STRING);
        $apellidos = filter_var($datos['apellidos'], FILTER_SANITIZE_STRING);
        $email = filter_var($datos['email'], FILTER_VALIDATE_EMAIL);
        $rol = filter_var($datos['rol'], FILTER_SANITIZE_STRING);
        // $password = filter_var($datos['password'], FILTER_SANITIZE_STRING); Comentado temporalmente para ver donde esta el error de la edicion del ROL

        // Validación con expresiones regulares (patrones)
        $patronNombre = "/^[a-zA-ZáéíóúÁÉÍÓÚ '-]*$/";  // Solo letras y espacios y apóstrofes
        $patronApellido = "/^[a-zA-ZáéíóúÁÉÍÓÚ '-]*$/";  // Solo letras, espacios, apóstrofes y guiones
        $patronCorreo = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/"; // Formato de correo electrónico
        $patronPassword = "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/"; //  Al menos una letra y un número, mínimo 6 caracteres

        // Validar el formato de los campos
        if (!preg_match($patronNombre, $nombre)) {
            throw new Exception('El nombre solo debe contener letras, espacios y apóstrofes.');
        }
        if (!preg_match($patronApellido, $apellidos)) {
            throw new Exception('Los apellidos solo deben contener letras, espacios, apóstrofes y guiones.');
        }
        if (!preg_match($patronCorreo, $email)) {
            throw new Exception('El correo electrónico debe seguir el formato example@example.com.');
        }

        // Si se proporciona una contraseña, validar su formato
        if (!empty($password) && !preg_match($patronPassword, $password)) {
            throw new Exception('La contraseña debe tener al menos una letra, un número y un mínimo de 6 caracteres.');
        }

        return [
            'id' => $id,
            'nombre' => $nombre,
            'apellidos' => $apellidos,
            'email' => $email,
            'rol' => $rol,
            'password' => !empty($password) ? $this->encriptarPassword($password) : null
        ];
    }
    // Método para actualizar un usuario
    public function actualizarUsuario()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $datos = $this->validarEdicionUsuario($_POST['datos']);
                if ($datos !== null) {
                    // Obtener el ID del administrador que ha iniciado sesión
                    $adminId = $_SESSION['inicioSesion']->id;

                    // Verificar si el usuario que se está editando es el administrador actual
                    if ($datos['id'] == $adminId && $datos['rol'] === 'usuario') {
                        $_SESSION['error'] = 'No puedes cambiarte tu propio rol a "usuario".';
                        header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
                        return;
                    }

                    // Si no es el mismo o no intenta cambiar su rol a "usuario", proceder con la actualización
                    $usuario = Usuario::fromArray($datos);
                    // die(var_dump($usuario));
                    $usuarioActualizado = $this->usuarioServices->update($usuario);

                    if ($usuarioActualizado) {
                        $_SESSION['actualizacion'] = 'correcta';
                    } else {
                        $_SESSION['actualizacion'] = 'incorrecta';
                    }
                } else {
                    $_SESSION['actualizacion'] = 'incorrecta';
                }
                header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
            }
        } catch (Exception $e) {
            $_SESSION['actualizacion'] = 'incorrecta';
            $_SESSION['mensajesError'] = [$e->getMessage()]; // Guardar el mensaje de error en la sesión
            header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
        }
    }
    // Método para eliminar un usuario
    public function eliminarUsuario($id)
    {
        // Obtener el ID del administrador que ha iniciado sesión
        $adminId = $_SESSION['inicioSesion']->id;

        // Verificar si el ID del usuario a eliminar es el mismo que el del administrador
        if ($id == $adminId) {
            $_SESSION['error'] = 'No puedes eliminarte a ti mismo.';
            header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
            return;
        }

        // Si no es el mismo, proceder con la eliminación
        $this->usuarioServices->delete($id);
        header('Location: ' . BASE_URL . 'Administrador/mostrarUsuarios');
    }


    public function cerrarSesion()
    {
        // Eliminar la sesión de inicio de sesión
        Utils::eliminarSesion('inicioSesion');
        Utils::eliminarSesion('recordarUsuario');

        // Eliminar el carrito asociado al usuario
        if (isset($_SESSION['carrito'])) {
            unset($_SESSION['carrito']); // Elimina el carrito de la sesión
        }

        // Eliminar cookie de usuario si existe
        if (isset($_COOKIE['usuario'])) {
            setcookie('usuario', '', time() - 3600, "/"); // Expira en el pasado
        }

        // Redirigir al inicio de sesión
        header('Location: ' . BASE_URL);
    }

    public function editarPerfil()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $_POST['datos'];

            // Convertir el array en un objeto Usuario
            $usuario = Usuario::fromArray($datos);

            // Validar los datos del formulario
            $usuarioActualizado = $this->usuarioServices->update($usuario);

            if ($usuarioActualizado) {
                // Actualizar los datos del usuario en la sesión
                $_SESSION['inicioSesion']->nombre = $usuario->getNombre();
                $_SESSION['inicioSesion']->apellidos = $usuario->getApellidos();
                $_SESSION['inicioSesion']->email = $usuario->getEmail();

                $_SESSION['actualizacion'] = 'correcta';
                header('Location: ' . BASE_URL . 'Usuario/editarPerfil');
            } else {
                $_SESSION['actualizacion'] = 'incorrecta';
            }
        } else {
            // Obtener los datos del usuario actual
            $usuario = $this->usuarioServices->getById($_SESSION['inicioSesion']->id);
            $this->pages->render('Usuario/editarPerfil', ['usuario' => $usuario]);
        }
    }
}

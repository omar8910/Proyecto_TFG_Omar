<?php
// 

namespace Routes;

use Controllers\DashboardController;
use Controllers\ErrorController;
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Controllers\UsuarioController;

use Lib\Router;

class Routes
{
    public static function index()
    {
        // Ruta dashboard
        Router::add('GET', '/', function () {
            return (new DashboardController())->index();
        });

        // Ruta ver categoria
        Router::add('GET', 'Categoria/verCategoria/?id=:id', function ($id) {
            return (new CategoriaController())->verCategoria($id);
        });

        // Ruta ver detalles producto
        Router::add('GET', 'Producto/verProducto/?id=:id', function ($id) {
            return (new ProductoController())->verProducto($id);
        });

        // Ruta inicio de sesión y registro
        Router::add('GET', 'Usuario/iniciarSesion', function () {
            return (new UsuarioController())->iniciarSesion();
        });

        Router::add('POST', 'Usuario/iniciarSesion', function () {
            return (new UsuarioController())->iniciarSesion();
        });

        Router::add('GET', 'Usuario/registrarUsuarios', function () {
            return (new UsuarioController())->registrarUsuario();
        });

        Router::add('POST', 'Usuario/registrarUsuarios', function () {
            return (new UsuarioController())->registrarUsuario();
        });

        // Ruta para cerrar sesión
        Router::add('GET', 'Usuario/cerrarSesion', function () {
            return (new UsuarioController())->cerrarSesion();
        });

        // RUTAS DE ADMINISTRADOR

        // Apartado de usuarios
        Router::add('GET', 'Administrador/mostrarUsuarios', function () {
            return (new UsuarioController())->obtenerTodosUsuarios();
        });

        Router::add('GET', 'Administrador/eliminarUsuario/?id=:id', function ($id) {
            return (new UsuarioController())->eliminarUsuario($id);
        });

        Router::add('GET', 'Administrador/editarUsuario/?id=:id', function ($id) {
            return (new UsuarioController())->editarUsuario($id);
        });

        Router::add('POST', 'Administrador/actualizarUsuario', function () {
            return (new UsuarioController())->actualizarUsuario();
        });


        // Apartado de categorias

        Router::add('GET', 'Administrador/gestionarCategorias', function () {
            return (new CategoriaController())->gestionarCategorias();
        });

        // Rutas Error
        Router::add('GET', '/errores/', function () {
            return (new ErrorController())->error404();
        });

        Router::dispatch(); // Se encarga de ejecutar la ruta que se ha configurado basándose en la URL
    }
}

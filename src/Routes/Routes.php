<?php
// 

namespace Routes;

use Controllers\DashboardController;
use Controllers\ErrorController;
use Controllers\CategoriaController;
use Controllers\ProductoController;
use Controllers\UsuarioController;
use Controllers\CarritoController;

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

        // Ruta para carrito
        Router::add('GET', 'Carrito/verCarrito', function () {
            return (new CarritoController())->mostrarCarrito();
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

        Router::add('GET', 'Administrador/crearCategoria', function () {
            return (new CategoriaController())->crearCategoria();
        });

        Router::add('POST', 'Administrador/crearCategoria', function () {
            return (new CategoriaController())->crearCategoria();
        });

        Router::add('GET', 'Administrador/eliminarCategoria/?id=:id', function ($id) {
            return (new CategoriaController())->eliminarCategoria($id);
        });

        Router::add('GET', 'Administrador/editarCategoria/?id=:id', function ($id) {
            return (new CategoriaController())->editarCategoria($id);
        });

        Router::add('POST', 'Administrador/actualizarCategoria', function () {
            return (new CategoriaController())->actualizarCategoria();
        });
        
        // Apartado de productos

        Router::add('GET', 'Administrador/gestionarProductos', function () {
            return (new ProductoController())->gestionarProductos();
        });

        Router::add('GET', 'Administrador/crearProducto', function () {
            return (new ProductoController())->crearProducto();
        });

        Router::add('POST', 'Administrador/crearProducto', function () {
            return (new ProductoController())->crearProducto();
        });

        Router::add('GET', 'Administrador/eliminarProducto/?id=:id', function ($id) {
            return (new ProductoController())->eliminarProducto($id);
        });

        Router::add('GET', 'Administrador/editarProducto/?id=:id', function ($id) {
            return (new ProductoController())->editarProducto($id);
        });

        Router::add('POST', 'Administrador/editarProducto', function () {
            return (new ProductoController())->editarProducto();
        });

        // Rutas Error
        Router::add('GET', '/errores/', function () {
            return (new ErrorController())->error404();
        });

        Router::dispatch(); // Se encarga de ejecutar la ruta que se ha configurado basándose en la URL
    }
}

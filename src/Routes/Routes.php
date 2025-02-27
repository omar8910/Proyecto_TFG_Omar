<?php
// 

namespace Routes;

use Controllers\DashboardController;
use Controllers\ErrorController;
use Controllers\CategoriaController;
use Controllers\ProductoController;


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
        Router::add('GET','Categoria/verCategoria/?id=:id', function($id){
            return (new CategoriaController())->verCategoria($id);
        });

        // Ruta ver detalles producto
        Router::add('GET', 'Producto/verProducto/?id=:id', function($id){
            return (new ProductoController())->verProducto($id);
        });



        // // Rutas Error
        Router::add('GET', '/errores/', function () {
            return (new ErrorController())->error404();
        });

        Router::dispatch(); // Se encarga de ejecutar la ruta que se ha configurado basándose en la URL
    }
}

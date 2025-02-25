<?php
// 

namespace Routes;

use Controllers\DashboardController;
use Controllers\ErrorController;


use Lib\Router;

class Routes
{
    public static function index()
    {
        // Ruta dashboard
        Router::add('GET', '/', function () {
            return (new DashboardController())->index();
        });



        // // Rutas Error
        // Router::add('GET', '/errores/', function () {
        //     return (new ErrorController())->error404();
        // });

        Router::dispatch(); // Se encarga de ejecutar la ruta que se ha configurado basándose en la URL
    }
}

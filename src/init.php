<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Desactivar todos los errores visibles en producción
error_reporting(0);
ini_set('display_errors', 0);

// Añadir horario de la zona horaria de España
date_default_timezone_set('Europe/Madrid');

// Importa la clase Routes del espacio de nombres Routes
use Routes\Routes;

// Importa la clase Utils del espacio de nombres Utils
use Utils\Utils;

// Incluye el archivo autoload.php generado por Composer para cargar automáticamente las clases necesarias
require_once '../vendor/autoload.php';

// Incluye el archivo de configuración config.php
require_once '../config/config.php';

// Carga las variables de entorno desde un archivo .env ubicado en el directorio raíz del proyecto ( EN LOCAL)
// $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
// $dotenv->safeLoad();


// Verifica si la cookie de usuario ha expirado y cierra la sesión si es necesario.
// Lo ponemos en el init.php para que se ejecute en todas las páginas nada más cargar la aplicación.
if (isset($_SESSION['inicioSesion'])) {
    // Si la sesión está iniciada pero no hay cookie, solo la cerramos si el usuario eligió "Recordar usuario" antes
    if (!isset($_COOKIE['usuario']) && isset($_SESSION['recordarUsuario']) && $_SESSION['recordarUsuario'] === true) {
        Utils::eliminarSesion('inicioSesion');
        Utils::eliminarSesion('recordarUsuario'); // Eliminamos también este flag
        header('Location: ' . BASE_URL . 'Usuario/iniciarSesion');
        exit();
    }
}




// Llama al método index de la clase Routes para manejar las rutas de la aplicación
Routes::index();

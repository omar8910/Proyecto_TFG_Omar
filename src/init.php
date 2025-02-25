<?php
// Inicia una nueva sesión o reanuda la sesión existente
session_start();

// Importa la clase Routes del espacio de nombres Routes
use Routes\Routes;

// Incluye el archivo autoload.php generado por Composer para cargar automáticamente las clases necesarias
require_once '../vendor/autoload.php';

// Incluye el archivo de configuración config.php
require_once '../config/config.php';

// Carga las variables de entorno desde un archivo .env ubicado en el directorio raíz del proyecto
$dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->safeLoad();

// Llama al método index de la clase Routes para manejar las rutas de la aplicación
Routes::index();
?>
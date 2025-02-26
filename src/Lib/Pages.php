<?php

namespace Lib;

class Pages
{
    /*
     * Este método crea tantas variables como le pases en un array y carga las vistas de header y footer,
     * y entre ellas la vista que le indicaste.
     */
    public function render(string $pageName, array $params = null): void
    {
        // Si se pasan parámetros, crea variables dinámicas con los nombres y valores del array
        if ($params != null) {
            foreach ($params as $name => $value) {
                $$name = $value;
            }
        }

        // dirname(__DIR__, 1) sube un nivel en la jerarquía de directorios y se añade /Views/ para buscar las vistas en la carpeta views
        $rutasVistas = dirname(__DIR__, 1) . "/Views/";

        // Incluye el archivo de la cabecera
        require_once $rutasVistas . "Layout/header.php";
        // Incluye el archivo de la vista específica
        require_once $rutasVistas . "$pageName.php";
        // Incluye el archivo del pie de página
        require_once $rutasVistas . "Layout/footer.php";
    }
}
?>
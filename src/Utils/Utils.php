<?php
/*La carpeta "Utils" (utilidades) generalmente se utiliza para almacenar
 clases que contienen métodos que realizan tareas comunes
  y que pueden ser utilizados en varias partes de la aplicación.
  Estos métodos pueden incluir funciones para manejar fechas,
  cadenas de texto, sesiones, archivos, etc. */

namespace Utils;

class Utils
{
    public static function eliminarSesion($nombreSesion): void
    {
        if (isset($_SESSION[$nombreSesion])) {
            $_SESSION[$nombreSesion] = null; // La ponemos a null para asegurarnos de que no contenga nada
            unset($_SESSION[$nombreSesion]); // Y la eliminamos con unset();
        }
    }

    public static function validarString($string): string
    {
        // Quitale las etiquetas HTML y PHP
        $string = strip_tags($string);
        // Convierte una cadena con caracteres especiales en una cadena con caracteres HTML
        $string = htmlspecialchars($string);
        return $string;
    }
    
}

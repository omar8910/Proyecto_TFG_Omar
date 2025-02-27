<?php
namespace Controllers;
use Lib\Pages;

class ErrorController{
    private Pages $pages;

    public function __construct()
    {
        $this->pages = new Pages();
    }

    public function error404(){
        $codigoError = 'Error 404';
        $mensajeError = 'Lo sentimos, no hemos encontrado la página que buscas :(';
        $this->pages->render('errores/error404', ['codigoError' => $codigoError, 'mensajeError'=> $mensajeError]);
    }
}





?>
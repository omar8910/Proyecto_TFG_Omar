<?php

namespace Controllers;
use Lib\Pages;


class DashboardController{
    
    private Pages $pages;

    
    function __construct(){

        $this->pages = new Pages();

    }

    public function index(): void{
        $productos = [
            ['nombre' => 'Producto 1', 'precio' => 100],
            ['nombre' => 'Producto 2', 'precio' => 200],
            ['nombre' => 'Producto 3', 'precio' => 300],
            ['nombre' => 'Producto 4', 'precio' => 400],
            ['nombre' => 'Producto 5', 'precio' => 500],
        ];

        $categorias = [
            ['nombre' => 'Categoria 1'],
            ['nombre' => 'Categoria 2'],
            ['nombre' => 'Categoria 3'],
            ['nombre' => 'Categoria 4'],
            ['nombre' => 'Categoria 5'],
        ];
        
        $this->pages->render('Dashboard/index', ['productos' => $productos, 'categorias' => $categorias]);
    }
}
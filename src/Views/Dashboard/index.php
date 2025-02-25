<?php 
foreach($productos as $producto){
    echo $producto['nombre'] . ' - ' . $producto['precio'] . '<br>';
}

foreach($categorias as $categoria){
    echo $categoria['nombre'] . '<br>';
}



?>
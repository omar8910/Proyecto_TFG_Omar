<?php
// Copiado de la policlinica, con algunas modificaciones
namespace Lib;

use PDOException;
use PDO;

class BaseDatos
{

  private  $conexion;
  private mixed $resultado; //mixed novedad en PHP cualquier valor
  private string $servidor;
  private string $usuario;
  private string $pass;
  private string $base_datos;

  // En caso de las variables de entorno no se puede hacer promoción de propiedades en el constructor
  function __construct()
  {
    $this->servidor =  $_ENV['DB_HOST'];
    $this->usuario = $_ENV['DB_USER'];
    $this->pass = $_ENV['DB_PASS'];
    $this->base_datos = $_ENV['DB_DATABASE'];
    $this->conexion = $this->conectar();
  }

  private function conectar(): PDO
  {

    try {
      $opciones = array(
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::MYSQL_ATTR_FOUND_ROWS => true

      );

      $conexion = new PDO("mysql:host={$this->servidor};dbname={$this->base_datos}", $this->usuario, $this->pass, $opciones);
      // Se recomienda activar esta opción para gestionar los errores con PDOException
      $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conexion;
    } catch (PDOException $e) {
      echo 'Ha surgido un error y no se puede conectar a la base de datos. Detalle: ' . $e->getMessage();
      exit;
    }
  }
  // Funcion para realizar consultas a la base de datos
  public function consulta(string $consultaSQL): void
  {
    $this->resultado = $this->conexion->query($consultaSQL);
  }

  // Función para extraer un solo registro de la base de datos
  public function extraer_registro(): mixed
  {
    return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC)) ? $fila : false; // Devuelve un array con el registro o false si no hay más registros
    // FETCH_ASSOC: Devuelve un array indexado por los nombres de las columnas de la tabla
  }

  // Función para extraer todos los registros de la base de datos
  public function extraer_todos(): array
  {
    return $this->resultado->fetchAll(PDO::FETCH_ASSOC); // Devuelve un array con todos los registros
    // FETCH_ASSOC: Devuelve un array indexado por los nombres de las columnas de la tabla
  }

  // Función para obtener el número de filas afectadas por una consulta
  public function filasAfectadas(): int
  {
    return $this->resultado->rowCount();
  }

  // Función para obtener el último id insertado en la base de datos
  public function lastInsertId()
  {
    return $this->conexion->lastInsertId();
  }

  /* TEORIA IMPORTANTE

    Estas consultas se inicializan una sola vez con el método prepare() y se
    ejecutan, las veces que sea necesario, con el método execute() asignando
    diferentes valores a los parámetros.

    Las consultas preparadas son más rápidas y seguras que las consultas normales, y hay que
    usarlas con marcadores de parámetros para evitar la inyección SQL. 

    EJEMPLO:
      -- Preparamos la consulta
      $ins = $bd->prepare("INSERT INTO usuarios(nombre, clave, rol) VALUES (:nombre, :clave, :rol)");
      -- La ejecutamos
      $ins->execute(array(':nombre' => 'Omar', ':clave' => '1234', ':rol' => 'admin'));
      -- La cerramos
      $ins->closeCursor();

    BindParam: Vincula una variable de PHP a un parámetro de sustitución con nombre correspondiente de la sentencia SQL que fue usada para preparar la sentencia.
    BindValue: Asigna un valor a un parámetro de sustitución con nombre correspondiente de la sentencia SQL que fue usada para preparar la sentencia.

    En la práctica bindValue() se suele usar cuando se tienen que insertar datos
    sólo una vez, y bindParam() cuando se tienen que pasar datos múltiples
    (desde un array por ejemplo).

    Los tipos de datos más utilizados son:
    PDO::PARAM_BOOL(booleano), PDO::PARAM_NULL(null),
    PDO::PARAM_INT(integer) y PDO::PARAM_STR (string).

    EJEMPLO:
      -- Preparamos la consulta
        $ins = $bd->prepare("INSERT INTO usuarios(nombre, clave, rol) VALUES (:nombre, :clave, :rol)");
      -- Vinculamos las variables
        $ins->bindParam(':nombre', $nombre);
        $ins->bindParam(':clave', $clave);
        $ins->bindParam(':rol', $rol);
      -- Asignamos los valores
        $nombre = 'Omar';
        $clave = '1234';
        $rol = 'admin';
      -- La ejecutamos
        $ins->execute();
      -- La cerramos
        $ins->closeCursor();

  */

  // Función para preparar una consulta
  public function prepara($consulta)
  {
    // die($consulta);
    return $this->conexion->prepare($consulta);
  }

  // Función para liberar la memoria utilizada por un resultado después de terminar con él (evitar fugas de memoria)
  public function close()
  {
    if ($this->conexion !== null) {
      $this->conexion = null; // Cierra la conexión a la base de datos
    }
  }

  // Una transacción es un conjunto de operaciones que se ejecutan como una sola unidad, se escribe antes de la consulta.
  public function empezarTransaccion()
  {
    $this->conexion->beginTransaction();
  }

  // Confirma las operaciones realizadas en una transacción en caso de que no haya errores en las consultas y lo guarda en la base de datos.
  // Despues de la ejecucion de la consulta (execute())
  public function confirmarTransaccion()
  {
    $this->conexion->commit();
  }

  // Cancela las operaciones realizadas en una transacción en caso de que haya errores en las consultas y no lo guarda en la base de datos.
  public function cancelarTransaccion()
  {
    $this->conexion->rollBack();
  }
}

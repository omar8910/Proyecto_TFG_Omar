<?php

namespace Models;

use Lib\BaseDatos;

class Usuario
{
    // Constructor
    public function __construct(
        private ?int $id, // El signo de interrogación indica que el valor puede ser nulo
        private string $nombre,
        private string $apellidos,
        private string $email,
        private string $password,
        private string $rol,
        private BaseDatos $BaseDatos = new BaseDatos()
    ) {}

    // Getters
    public function getId(): int|null
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRol(): string
    {
        return $this->rol;
    }

    // Setters

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setApellidos(string $apellidos): void
    {
        $this->apellidos = $apellidos;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function setRol(string $rol): void
    {
        $this->rol = $rol;
    }

    // Métodos

    /* Este método nos permite hacer la correspondencia o mapeo de cada
         array de un registro obtenido de la consulta de la base de datos
         a un objeto de tipo Usuario.

         Al ser estático me permite crear un objeto de tipo Usuario a partir de un array asociativo, sin tener que estanciarlo.
          ejemplo:
            $datos = ['id' => 1, 'nombre' => 'Omar', 'apellidos' => 'Diaz', 'email' => 'ejemplo@gmail.com', 'password' => '1234', 'rol' => 'admin'];
            $usuario = Usuario::fromArray($datos);
        */

    public static function fromArray(array $datos): Usuario
    {
        return new Usuario(
            $datos['id'] ?? null,
            $datos['nombre'] ?? '',
            $datos['apellidos'] ?? '',
            $datos['email'] ?? '',
            $datos['password'] ?? '',
            $datos['rol'] ?? ''
        );
    }

    public function desconexion()
    {
        $this->BaseDatos->close();
    }
}

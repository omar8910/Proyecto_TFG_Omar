<?php
namespace Services;
use Repositories\UsuarioRepository;

class UsuarioServices{
    private UsuarioRepository $usuarioRepository;

    public function __construct(UsuarioRepository $usuarioRepository){
        $this->usuarioRepository = $usuarioRepository;
    }

    public function create($usuario){
        return $this->usuarioRepository->create($usuario);
    }

    public function update($usuario){
        return $this->usuarioRepository->update($usuario);
    }

    public function delete($id){
        return $this->usuarioRepository->delete($id);
    }

    public function getById($id){
        return $this->usuarioRepository->getById($id);
    }

    public function getByEmail($email){
        return $this->usuarioRepository->getByEmail($email);
    }

    public function iniciarSesion($usuario){
        return $this->usuarioRepository->iniciarSesion($usuario);
    }

    public function obtenerTodosUsuarios(){
        return $this->usuarioRepository->obtenerTodosUsuarios();
        
    }
    
}


?>
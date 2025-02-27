<?php

namespace Services;

use Repositories\CategoriaRepository;

class CategoriaServices
{
    private CategoriaRepository $categoriaRepository;

    public function __construct(CategoriaRepository $categoriaRepository)
    {
        $this->categoriaRepository = $categoriaRepository;
    }

    public function create($categoria)
    {
        return $this->categoriaRepository->create($categoria);
    }

    public function update($id, $nombre)
    {
        return $this->categoriaRepository->update($id, $nombre);
    }

    public function delete($id)
    {
        // die('Eliminar categoria' . $id);
        return $this->categoriaRepository->delete($id);
    }


    public function getById($id)
    {
        return $this->categoriaRepository->getById($id);
    }

    public function obtenerTodasCategorias()
    {
        return $this->categoriaRepository->obtenerTodasCategorias();
    }
}

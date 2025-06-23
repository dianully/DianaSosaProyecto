<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\GenerosModel;

class Generos extends BaseController
{
    protected $generos;

    public function __construct()
    {
        $this->generos = new GenerosModel();
    }

    public function index($activo = 1)
    {
        $generos = $this->generos->where('activo',$activo)->findAll();
        $data = ['datos' => $generos];
        
        return view('templates/layout', [
            'title' => 'Generos',
            'content' => view('pages/generos/generos',$data)
        ]);
    }

    public function eliminados($activo = 0)
    {
        $generos = $this->generos->where('activo',$activo)->findAll();
        $data = ['datos' => $generos];
        
        return view('templates/layout', [
            'title' => 'Eliminados',
            'content' => view('pages/generos/eliminados',$data)
        ]);
    }

    public function nuevo()
    {
        return view('templates/layout', [
            'title' => 'Agregar Genero',
            'content' => view('pages/generos/nuevo')
        ]);
    }

    public function insertar()
    {
        $this->generos->save(['nombre' => $this->request->getPost('nombre')]);
        return redirect()->to(base_url().'/Generos');
    }

    public function Editar($id)
{
    // CAMBIA 'id_generos' a 'id_genero' (singular)
    $genero = $this->generos->where('id_genero', $id)->first(); // CORRECTO
    $data = ['datos' => $genero];

    return view('templates/layout', [
        'title' => 'Editar Genero',
        'content' => view('pages/generos/editar',$data)
    ]);
}

   public function actualizar()
{
    // CAMBIA 'id_generos' a 'id_genero' (singular)
    // O MEJOR AÚN, USA $this->request->getPost($this->generos->primaryKey)
    $this->generos->update($this->request->getPost('id_genero'), ['nombre' => $this->request->getPost('nombre')]); // CORRECTO
    return redirect()->to(base_url().'/Generos');
}

    public function eliminar($id)
    {
        $this->generos->update($id, ['activo' => 0]);
        return redirect()->to(base_url().'/Generos');
    }

    public function reingresar($id)
    {
        $this->generos->update($id, ['activo' => 1]);
        return redirect()->to(base_url().'/Generos');
    }
}
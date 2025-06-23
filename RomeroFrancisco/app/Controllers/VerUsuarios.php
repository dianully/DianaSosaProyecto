<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class VerUsuarios extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        // Restringir acceso solo a administradores
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Acceso denegado');
        }
    }

    public function index()
    {
        $usuarios = $this->usuarioModel->findAll();
        return view('templates/layout', [
            'title' => 'Lista de Usuarios',
            'content' => view('pages/ver_usuarios', ['usuarios' => $usuarios])
        ]);
    }
}
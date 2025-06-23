<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class CerrarSesion extends Controller
{
    public function index()
    {
        session()->destroy();
        session()->setFlashdata('success', 'Sesion cerrada exitosamente.');
        return redirect()->to('/ingresar');
    }
}
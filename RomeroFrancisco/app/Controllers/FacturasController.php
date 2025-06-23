<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FacturasController extends Controller
{
    public function index()
    {
        // Verificar si hay sesión activa y es administrador
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            session()->setFlashdata('error', 'Debes ser administrador para acceder a esta página.');
            return redirect()->to('/ingresar');
        }

        return view('templates/layout', [
            'title' => 'Ver Facturas',
            'content' => view('pages/facturas_cliente')
        ]);
    }
}
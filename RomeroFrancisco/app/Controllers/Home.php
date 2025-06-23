<?php

namespace App\Controllers;

use App\Models\ProductosModel;
use App\Models\GenerosModel;

class Home extends BaseController
{
    
    public function index()
    {
    return redirect()->to('/catalogo/catalogo_inicio');
    }

    public function QuienesSomos()
    {
        return view('templates/layout', [
            'title' => 'Quienes Somos',
            'content' => view('pages/QuienesSomos')
        ]);
    }

    public function Comercializacion()
    {
        return view('templates/layout', [
            'title' => 'Comercializacion',
            'content' => view('pages/comercializacion')
        ]);
    }

    public function InformacionDeContacto()
    {
        return view('templates/layout', [
            'title' => 'Contacto',
            'content' => view('pages/informacionContacto')
        ]);
    }

    public function TerminosYUsos()
    {
        return view('templates/layout', [
            'title' => 'Terminos y Usos',
            'content' => view('pages/terminosYUsos')
        ]);
    }
}
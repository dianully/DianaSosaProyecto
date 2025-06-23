<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AdminDashboard extends Controller
{
    public function index()
    {
        // Verificar si hay sesión activa y es administrador
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            session()->setFlashdata('error', 'Debes ser administrador para acceder a esta página.');
            return redirect()->to('/ingresar');
        }

        // Verificar si es el primer login
        if (session()->get('primer_login') == 1) {
            session()->setFlashdata('success', 'Registro completado exitosamente. Bienvenido administrador.');
            session()->set('primer_login', 0); // Actualizar primer_login a 0
            $this->usuarioModel->update(session()->get('user_id'), ['primer_login' => 0]);
        }

        return view('templates/layout', [
            'title' => 'Panel de Administrador',
            'content' => view('pages/admin_dashboard')
        ]);
    }
}
<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class PerfilController extends Controller
{
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
{
    $session = session();
    if (!$session->has('id_rol')) {
        session()->setFlashdata('error', 'Debes iniciar sesion para acceder a esta pagina.');
        return redirect()->to('/ingresar');
    }

    // Ahora sí, obtener correctamente el id del usuario logueado
    $userId = $session->get('id_usuario');
    $usuario = $this->usuarioModel->find($userId);

    if (!$usuario) {
        session()->setFlashdata('error', 'Usuario no encontrado.');
        return redirect()->to('/ingresar');
    }

    return view('templates/layout', [
        'title' => 'Editar Perfil',
        'content' => view('pages/editar_perfil', [
            'usuario' => $usuario
        ])
    ]);
}


    public function guardar()
{
    $session = session();
    if (!$session->has('id_rol')) {
        session()->setFlashdata('error', 'Debes iniciar sesion para guardar cambios.');
        return redirect()->to('/ingresar');
    }

    // Ahora sí, obtenemos correctamente el id de usuario
    $userId = $session->get('id_usuario');
    $currentUser = $this->usuarioModel->find($userId);

    if (!$currentUser) {
        session()->setFlashdata('error', 'Usuario no encontrado para actualizar.');
        return redirect()->to('/editar_perfil');
    }

    if (is_object($currentUser)) {
        $currentUser = (array) $currentUser;
    }

    $data = [
        'nombre' => $this->request->getPost('nombre'),
        'apellido' => $this->request->getPost('apellido'),
        'dni' => $this->request->getPost('dni'),
        'telefono' => $this->request->getPost('telefono'),
        'email' => $this->request->getPost('email'),
        'domicilio' => $this->request->getPost('domicilio'),
    ];

    $emailChanged = isset($data['email'], $currentUser['email']) && $data['email'] !== $currentUser['email'];
    $dniChanged = isset($data['dni'], $currentUser['dni']) && $data['dni'] !== $currentUser['dni'];

    if ($emailChanged) {
        $existingUserWithNewEmail = $this->usuarioModel->where('email', $data['email'])->first();
        if ($existingUserWithNewEmail && $existingUserWithNewEmail['id_usuario'] != $userId) {
            session()->setFlashdata('error', 'El correo electrónico ingresado ya esta registrado por otro usuario.');
            return redirect()->to('/editar_perfil');
        }
    }

    if ($dniChanged) {
        $existingUserWithNewDni = $this->usuarioModel->where('dni', $data['dni'])->first();
        if ($existingUserWithNewDni && $existingUserWithNewDni['id_usuario'] != $userId) {
            session()->setFlashdata('error', 'El DNI ingresado ya esta registrado por otro usuario.');
            return redirect()->to('/editar_perfil');
        }
    }

    $this->usuarioModel->skipValidation(true);

    if ($this->usuarioModel->update($userId, $data)) {
        $session->set([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'email' => $data['email']
        ]);

        session()->setFlashdata('success', 'Cambios guardados exitosamente.');
        return redirect()->to('/editar_perfil');
    } else {
        $errors = $this->usuarioModel->errors();
        session()->setFlashdata('error', 'Error al guardar los cambios: ' . json_encode($errors));
        return redirect()->to('/editar_perfil');
    }
}



}
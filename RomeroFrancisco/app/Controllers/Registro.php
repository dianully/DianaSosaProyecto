<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class Registro extends Controller
{
    protected $helpers = ['form'];
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        $session = session();
        if ($session->has('id_rol') && $session->get('id_rol') != 1) {
            log_message('debug', 'Sesion activa detectada al entrar a /registrar. Cerrando sesion.');
            $session->destroy();
        }

        return view('templates/layout', [
            'title' => 'Registrarse',
            'content' => view('pages/registrar')
        ]);
    }

    public function save()
{
    try {
        $contrasena = $this->request->getPost('contrasena');
        $confirmarContrasena = $this->request->getPost('confirmar_contrasena');

        if ($contrasena !== $confirmarContrasena) {
            session()->setFlashdata('error', 'Las contraseñas no coinciden.');
            return redirect()->to('/registrar')->withInput();
        }

        $email = $this->request->getPost('email');
        $dni = $this->request->getPost('dni');

        // ✅ Verificación de Email y DNI para TODOS los usuarios
        $existingUserWithEmail = $this->usuarioModel->where('email', $email)->first();
        if ($existingUserWithEmail) {
            session()->setFlashdata('error', 'El correo electrónico ya está registrado por otro usuario.');
            return redirect()->to('/registrar')->withInput();
        }

        $existingUserWithDni = $this->usuarioModel->where('dni', $dni)->first();
        if ($existingUserWithDni) {
            session()->setFlashdata('error', 'El DNI ingresado ya está registrado por otro usuario.');
            return redirect()->to('/registrar')->withInput();
        }

        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'dni' => $dni,
            'email' => $email,
            'telefono' => $this->request->getPost('telefono'),
            'domicilio' => $this->request->getPost('domicilio'),
            'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
            'activo' => 1,
        ];

        $session = session();
        $idRol = $session->get('id_rol');
        $isAdmin = $session->has('id_rol') && $idRol == 1;
        $sessionEmail = $session->get('email');

        if ($isAdmin) {
            if ($email !== $sessionEmail) {
                session()->setFlashdata('error', 'El correo ingresado no coincide con el de tu sesión.');
                return redirect()->to('/registrar')->withInput();
            }

            $existingUser = $this->usuarioModel->where('email', $email)->first();
            if (!$existingUser) {
                session()->setFlashdata('error', 'Error: No se encontró el correo en la base de datos. Contacta al administrador.');
                return redirect()->to('/registrar')->withInput();
            }

            $userId = $existingUser['id_usuario'];
            $data['id_rol'] = 1;
            $data['primer_login'] = 0;

            $db = \Config\Database::connect();
            $builder = $db->table('usuarios');
            $builder->where('id_usuario', $userId);
            if ($builder->update($data)) {
                $session->set('primer_login', 0);
                session()->setFlashdata('success', 'Registro completado exitosamente. Bienvenido administrador.');
                return redirect()->to('/admin_dashboard');
            } else {
                $errors = $db->error();
                session()->setFlashdata('error', 'Error al actualizar los datos: ' . ($errors['message'] ?? json_encode($errors)));
                log_message('error', 'Fallo al actualizar usuario ID ' . $userId . ': ' . ($errors['message'] ?? json_encode($errors)));
                return redirect()->to('/registrar')->withInput();
            }
        } else {
            $data['id_rol'] = 2;
            $data['primer_login'] = 0;

            if ($this->usuarioModel->insert($data)) {
                session()->setFlashdata('success', 'Registro exitoso. Por favor inicia sesión.');
                return redirect()->to('/ingresar');
            } else {
                $errors = $this->usuarioModel->errors();
                session()->setFlashdata('error', 'Error al guardar los datos: ' . json_encode($errors));
                log_message('error', 'Fallo al insertar cliente: ' . json_encode($errors));
                return redirect()->to('/registrar')->withInput();
            }
        }
    } catch (\Exception $e) {
        log_message('error', 'Error en Registro::save: ' . $e->getMessage());
        session()->setFlashdata('error', 'Error al procesar el registro: ' . $e->getMessage());
        return redirect()->to('/registrar')->withInput();
    }
}

}
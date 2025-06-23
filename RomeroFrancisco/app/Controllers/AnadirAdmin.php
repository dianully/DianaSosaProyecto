<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class AnadirAdmin extends Controller
{
    protected $helpers = ['form'];
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        return view('templates/layout', [
            'title' => 'Añadir Administrador',
            'content' => view('pages/anadir_admin')
        ]);
    }

    public function enviar()
{
    try {
        // Obtener y validar el correo
        $email = $this->request->getPost('correo');

        $rules = [
            'correo' => [
                'label' => 'Correo Electrónico',
                'rules' => 'required|valid_email|is_unique[Usuarios.email]',
                'errors' => [
                    'required' => 'El campo Correo Electrónico es obligatorio. Por favor intente nuevamente.',
                    'valid_email' => 'Por favor, ingresa un Correo Electrónico válido. Por favor intente nuevamente.',
                    'is_unique' => 'Este Correo Electrónico ya está registrado. Por favor intente nuevamente.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            $errorMessage = $this->validator->getErrors() ? implode(' ', $this->validator->getErrors()) : 'Error desconocido. Por favor intente nuevamente.';
            session()->setFlashdata('error', $errorMessage);
            return redirect()->to('/anadir_admin');
        }

        // Verificar si el correo ya existe (caso adicional por seguridad)
        if ($this->usuarioModel->where('email', $email)->first()) {
            session()->setFlashdata('error', 'Este Correo Electrónico ya está registrado. Por favor intente nuevamente.');
            return redirect()->to('/anadir_admin');
        }

        // Generar una contraseña temporal aleatoria (8 caracteres)
        $tempPassword = bin2hex(random_bytes(4)); // 8 caracteres hexadecimales (ej. a1b2c3d4)

        // Datos a guardar (solo los campos necesarios)
        $data = [
            'id_rol' => 1,
            'email' => $email,
            'contrasena' => password_hash($tempPassword, PASSWORD_DEFAULT),
            'primer_login' => 1,
            'activo' => 1,
        ];

        // Desactivar temporalmente la validación del modelo para este insert
        $this->usuarioModel->skipValidation(true);
        if ($this->usuarioModel->insert($data)) {
            $insertedId = $this->usuarioModel->insertID();
            session()->setFlashdata('success', "Administrador añadido exitosamente. Contraseña temporal: $tempPassword. ID: $insertedId. Copia la contraseña y compártela con el administrador.");
            return redirect()->to('/anadir_admin');
        } else {
            $errors = $this->usuarioModel->errors();
            session()->setFlashdata('error', 'Error al guardar el administrador. Por favor intente nuevamente.');
            log_message('error', 'Fallo al guardar usuario: ' . json_encode($errors));
            return redirect()->to('/anadir_admin');
        }
    } catch (\Exception $e) {
        log_message('error', 'Error en AnadirAdmin::enviar: ' . $e->getMessage());
        session()->setFlashdata('error', 'Error al procesar la solicitud. Por favor intente nuevamente.');
        return redirect()->to('/anadir_admin');
    } finally {
        // Reactivar la validación del modelo después del insert
        $this->usuarioModel->skipValidation(false);
    }
}
}
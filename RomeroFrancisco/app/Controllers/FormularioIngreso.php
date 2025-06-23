<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UsuarioModel;

class FormularioIngreso extends Controller
{
    protected $helpers = ['form'];
    protected $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        try {
            return view('templates/layout', [
                'title' => 'Iniciar Sesion',
                'content' => view('pages/ingresar')
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error en FormularioIngreso::index: ' . $e->getMessage());
            return "Error al cargar la pagina de login: " . $e->getMessage();
        }
    }

    public function send()
{
    try {
        // Validar el formulario
        $rules = [
            'email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'El campo Correo Electronico es obligatorio.',
                    'valid_email' => 'Por favor, ingresa un correo electronico valido.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required' => 'El campo Contrasena es obligatorio.',
                    'min_length' => 'La Contrasena debe tener al menos 8 caracteres.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            // Si la validacion falla, mostrar el formulario con errores y valores ingresados
            return view('templates/layout', [
                'title' => 'Iniciar Sesion',
                'content' => view('pages/ingresar', [
                    'validation' => $this->validator,
                    'email' => $this->request->getPost('email')
                ])
            ]);
        }

        // Verificar las credenciales
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $usuario = $this->usuarioModel->where('email', $email)->first();

        // Verificar si el usuario existe
        if (!$usuario) {
            session()->setFlashdata('error', 'El correo electronico no esta registrado.');
            return redirect()->to('/ingresar')->withInput();
        }

        // Verificar si el usuario esta activo
        if ($usuario['activo'] != 1) {
            session()->setFlashdata('error', 'Esta cuenta esta desactivada. Contacta a un administrador.');
            return redirect()->to('/ingresar')->withInput();
        }

        // Verificar la contrasena
        if (password_verify($password, $usuario['contrasena'])) {
            // Limpiar datos de sesiones anteriores
            session()->remove(['id_usuario', 'id_rol', 'email', 'primer_login']);

            // Iniciar sesion
            session()->set([
                'id_usuario' => $usuario['id_usuario'], // Cambiado de 'user_id' a 'id_usuario'
                'id_rol' => $usuario['id_rol'],
                'email' => $usuario['email'],
                'primer_login' => $usuario['primer_login']
            ]);

            // Si es el primer login y es administrador, redirigir a registrar
            if ($usuario['primer_login'] == 1 && $usuario['id_rol'] == 1) {
                session()->setFlashdata('info', 'Por favor, completa tu registro para continuar.');
                return redirect()->to('/registrar');
            }

            // Redirigir segun el rol
            if ($usuario['id_rol'] == 1) {
                session()->setFlashdata('success', 'Bienvenido administrador.');
                return redirect()->to('/admin_dashboard'); // Cambiado a /admin-dashboard
            } else {
                session()->setFlashdata('success', 'Bienvenido.');
                return redirect()->to('/'); // Pagina principal para clientes
            }
        } else {
            session()->setFlashdata('error', 'Contrasena incorrecta. Intenta nuevamente.');
            return redirect()->to('/ingresar')->withInput();
        }
    } catch (\Exception $e) {
        log_message('error', 'Error en FormularioIngreso::send: ' . $e->getMessage());
        session()->setFlashdata('error', 'Error al procesar el inicio de sesion: ' . $e->getMessage());
        return redirect()->to('/ingresar')->withInput();
    }
}
}
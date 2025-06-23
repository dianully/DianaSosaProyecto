<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Contacto extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper('form');
    }

    public function index()
    {
        $data = [
            'title' => 'Contacto',
            'content' => view('pages/informacionContacto', [
                'session_has_id_usuario' => session()->has('id_usuario')
            ])
        ];
        return view('templates/layout', $data);
    }

    public function verConsultas()
    {
        // Solo administradores pueden ver todas las consultas
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            return redirect()->to('/')->with('error', 'Acceso denegado. Solo administradores pueden ver las consultas.');
        }

        $builder = $this->db->table('consultas');
        
        $por_responder = $this->db->table('consultas')->where('Respondida', 0)->countAllResults();
        $respondidas = $this->db->table('consultas')->where('Respondida', 1)->countAllResults();

        $filter = $this->request->getGet('filter') == 'respondidas' ? 1 : 0;

        $consultas = $builder->select('consultas.id_consulta, consultas.motivoConsulta, consultas.comentarioAdicional, consultas.fecha, consultas.Respondida, consultas.Respuesta, consultas.id_usuario_responde, consultas.activo, consultas.id_usuario, 
                                      usuarios.nombre as user_nombre, usuarios.apellido as user_apellido, usuarios.email as user_email,
                                      consultas.nombre as consulta_nombre, consultas.apellido as consulta_apellido, consultas.email as consulta_email')
                             ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left') 
                             ->where('consultas.Respondida', $filter)
                             ->get()
                             ->getResultArray();

        return view('templates/layout', [
            'title' => 'Ver Consultas',
            'content' => view('pages/ver_consultas', [
                'consultas' => $consultas,
                'por_responder' => $por_responder,
                'respondidas' => $respondidas,
                'filter' => $filter
            ])
        ]);
    }

    public function detallesNoRespondidas($id_consulta)
    {
        // Solo administradores pueden ver los detalles de consultas no respondidas
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            return redirect()->to('/')->with('error', 'Acceso denegado.');
        }

        $builder = $this->db->table('consultas');
        
        $consulta = $builder->select('consultas.*, 
                                      usuarios.nombre as user_nombre, usuarios.apellido as user_apellido, usuarios.email as user_email')
                             ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left')
                             ->where('consultas.id_consulta', $id_consulta)
                             ->where('consultas.Respondida', 0)
                             ->get()
                             ->getRowArray();

        if (!$consulta) {
            return redirect()->to('/ver_consultas')->with('message', 'Consulta no encontrada o ya respondida.');
        }

        return view('templates/layout', [
            'title' => 'Detalles de Consulta No Respondida',
            'content' => view('pages/detalles_consultas_no_respondidas', ['consulta' => $consulta])
        ]);
    }

    public function detallesRespondidas($id_consulta)
    {
        // Solo administradores pueden ver los detalles de consultas respondidas
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            return redirect()->to('/')->with('error', 'Acceso denegado.');
        }

        $builder = $this->db->table('consultas');
        
        $consulta = $builder->select('consultas.*, 
                                      usuarios.nombre as user_nombre, usuarios.apellido as user_apellido, usuarios.email as user_email,
                                      admin.nombre as admin_nombre, admin.apellido as admin_apellido, admin.email as admin_email, admin.id_usuario as admin_id')
                             ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left') 
                             ->join('usuarios as admin', 'admin.id_usuario = consultas.id_usuario_responde', 'left') 
                             ->where('consultas.id_consulta', $id_consulta)
                             ->where('consultas.Respondida', 1)
                             ->get()
                             ->getRowArray();

        if (!$consulta) {
            return redirect()->to('/ver_consultas')->with('message', 'Consulta no encontrada o no respondida.');
        }

        return view('templates/layout', [
            'title' => 'Detalles de Consulta Respondida',
            'content' => view('pages/detalles_consultas_respondidas', ['consulta' => $consulta])
        ]);
    }

    public function sendResponse($id_consulta)
    {
        // Solo administradores pueden enviar respuestas
        if (!session()->has('id_rol') || session()->get('id_rol') != 1) {
            return $this->response->setJSON(['message' => 'Acceso denegado.']);
        }

        $respuesta = $this->request->getPost('respuesta');
        $admin_id = session()->get('id_usuario'); 

        if (!$respuesta) {
            return $this->response->setJSON(['message' => 'Por favor, escribe una respuesta.']);
        }

        $builder = $this->db->table('consultas');
        $builder->where('id_consulta', $id_consulta);
        $builder->update([
            'Respondida' => 1,
            'Respuesta' => $respuesta,
            'id_usuario_responde' => $admin_id,
            'vista_por_cliente' => 0 // Resetear a 0 cuando el admin responde, para que el cliente la vea como nueva.
        ]);

        if ($this->db->affectedRows() > 0) {
            return $this->response->setJSON(['message' => 'Mensaje enviado con éxito']);
        } else {
            return $this->response->setJSON(['message' => 'Error al enviar la respuesta']);
        }
    }

    public function send()
    {
        $hasSession = session()->has('id_usuario');
        $user_id = $hasSession ? session()->get('id_usuario') : null;

        $rules = [
            'motivoConsulta' => 'required',
            'comentarioAdicional' => 'required|min_length[10]'
        ];

        if (!$hasSession) {
            $rules['nombre'] = 'required';
            $rules['apellido'] = 'required';
            $rules['email'] = 'required|valid_email';
        }

        if (!$this->validate($rules)) {
            $validation = \Config\Services::validation();
            return view('templates/layout', [
                'title' => 'Contacto',
                'content' => view('pages/informacionContacto', [
                    'validation' => $validation,
                    'session_has_id_usuario' => $hasSession
                ])
            ]);
        }

        $data = [
            'motivoConsulta' => $this->request->getPost('motivoConsulta'),
            'comentarioAdicional' => $this->request->getPost('comentarioAdicional'),
            'fecha' => date('Y-m-d H:i:s'),
            'Respondida' => 0,
            'vista_por_cliente' => 0 // Por defecto, no vista al crear la consulta
        ];

        if ($hasSession) {
            $data['id_usuario'] = $user_id;
            $data['nombre'] = null; 
            $data['apellido'] = null;
            $data['email'] = null;
        } else {
            $data['nombre'] = $this->request->getPost('nombre');
            $data['apellido'] = $this->request->getPost('apellido');
            $data['email'] = $this->request->getPost('email');
            $data['id_usuario'] = null; 
        }

        $builder = $this->db->table('consultas');
        $builder->insert($data);

        if ($this->db->affectedRows() > 0) {
            return redirect()->to('/informacionContacto')->with('message', 'Gracias por contactarnos. Te responderemos a la brevedad.');
        } else {
            return redirect()->to('/informacionContacto')->with('message', 'Error al enviar la consulta. Inténtalo de nuevo.');
        }
    }

    public function verMiConsultaRespondida($id_consulta)
    {
        // Asegurarse de que el usuario está logueado y que NO es administrador
        if (!session()->has('id_usuario') || session()->get('id_rol') == 1) {
            return redirect()->to('/')->with('error', 'Acceso denegado. Solo clientes pueden ver sus consultas.');
        }

        $user_id = session()->get('id_usuario');

        $builder = $this->db->table('consultas');
        $consulta = $builder->select('consultas.*, 
                                      usuarios.nombre as user_nombre, usuarios.apellido as user_apellido, usuarios.email as user_email,
                                      admin.nombre as admin_nombre, admin.apellido as admin_apellido, admin.email as admin_email, admin.id_usuario as admin_id')
                         ->join('usuarios', 'usuarios.id_usuario = consultas.id_usuario', 'left') // Datos del consultante
                         ->join('usuarios as admin', 'admin.id_usuario = consultas.id_usuario_responde', 'left') // Datos del administrador
                         ->where('consultas.id_consulta', $id_consulta)
                         ->where('consultas.id_usuario', $user_id) // Solo mostrar la consulta si pertenece a este usuario
                         ->get()
                         ->getRowArray();

        if (!$consulta) {
            // Si la consulta no existe o no pertenece al usuario
            return redirect()->to(base_url())->with('error', 'Consulta no encontrada o no tienes permiso para verla.');
        }

        // Marcar la consulta como vista solo si ya fue respondida
        if ($consulta['Respondida'] == 1) {
            $this->db->table('consultas')
                     ->where('id_consulta', $id_consulta)
                     ->where('id_usuario', $user_id) // Seguridad extra
                     ->update(['vista_por_cliente' => 1]);
        }

        return view('templates/layout', [
            'title' => 'Detalles de Tu Consulta',
            'content' => view('pages/ver_detalles_respuesta_cliente', ['consulta' => $consulta])
        ]);
    }

    public function marcar_como_vista($id_consulta)
    {
        // Esta función ahora solo redirige al método que muestra los detalles y marca como vista
        return redirect()->to(base_url('contacto/ver_mi_consulta_respondida/' . $id_consulta));
    }
}
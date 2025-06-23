<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'array';
    protected $allowedFields = [
        'id_rol', 'email', 'contrasena', 'nombre', 'apellido', 'dni', 'telefono', 'primer_login', 'activo', 'domicilio'
    ];
    protected $useTimestamps = false;
    protected $validationRules = [
        'id_rol' => 'required|in_list[1,2]', // 1 para admin, 2 para cliente, ajusta según tus roles
        'email' => 'required|valid_email', // Quitamos is_unique para edición, lo manejaremos manualmente
        'contrasena' => 'required|min_length[8]',
        'nombre' => 'required|max_length[50]',
        'apellido' => 'required|max_length[50]',
        'dni' => 'required|min_length[8]|max_length[8]|numeric', // Quitamos is_unique para edición
        'telefono' => 'permit_empty|numeric|max_length[15]', // Opcional, ajusta según necesidad
        'primer_login' => 'required|in_list[0,1]',
        'activo' => 'required|in_list[0,1]',
        'domicilio' => 'permit_empty|max_length[100]|regex_match[/^[a-zA-Z0-9\s]+$/]', // Opcional, 100 caracteres, letras y números
    ];
    protected $validationMessages = [
        'id_rol' => [
            'required' => 'El rol es obligatorio.',
            'in_list' => 'Rol no valido.',
        ],
        'email' => [
            'required' => 'El correo electronico es obligatorio.',
            'valid_email' => 'Debe ingresar un correo valido.',
        ],
        'contrasena' => [
            'required' => 'La contrasena es obligatoria.',
            'min_length' => 'La contrasena debe tener al menos 8 caracteres.',
        ],
        'nombre' => [
            'required' => 'El nombre es obligatorio.',
            'max_length' => 'El nombre no puede exceder los 50 caracteres.',
        ],
        'apellido' => [
            'required' => 'El apellido es obligatorio.',
            'max_length' => 'El apellido no puede exceder los 50 caracteres.',
        ],
        'dni' => [
            'required' => 'El DNI es obligatorio.',
            'min_length' => 'El DNI debe tener 8 digitos.',
            'max_length' => 'El DNI debe tener 8 digitos.',
            'numeric' => 'El DNI debe contener solo numeros.',
        ],
        'telefono' => [
            'numeric' => 'El telefono debe contener solo numeros.',
            'max_length' => 'El telefono no puede exceder los 15 digitos.',
        ],
        'primer_login' => [
            'required' => 'El estado de primer login es obligatorio.',
            'in_list' => 'Valor de primer login no valido.',
        ],
        'activo' => [
            'required' => 'El estado de activo es obligatorio.',
            'in_list' => 'Valor de activo no valido.',
        ],
        'domicilio' => [
            'max_length' => 'El domicilio no puede exceder los 100 caracteres.',
            'regex_match' => 'El domicilio solo puede contener letras y numeros.',
        ],
    ];
    protected $skipValidation = false;
}
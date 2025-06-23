<?php

namespace App\Models;

use CodeIgniter\Model;

class DomicilioModel extends Model
{
    protected $table      = 'Domicilios';
    protected $primaryKey = 'id_domicilio';
    protected $returnType = 'array';
    protected $allowedFields = ['calle', 'numero', 'codigo_postal', 'localidad', 'provincia', 'pais'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    protected $validationRules = [
        'calle' => 'required|max_length[100]',
        'numero' => 'required|numeric',
        'codigo_postal' => 'required|max_length[10]',
        'localidad' => 'required|max_length[50]',
        'provincia' => 'required|max_length[50]',
        'pais' => 'required|max_length[50]',
    ];
    protected $validationMessages = [
        'calle' => ['required' => 'La calle es obligatoria.'],
        'numero' => ['required' => 'El número es obligatorio.', 'numeric' => 'El número debe ser numérico.'],
        'codigo_postal' => ['required' => 'El código postal es obligatorio.'],
        'localidad' => ['required' => 'La localidad es obligatoria.'],
        'provincia' => ['required' => 'La provincia es obligatoria.'],
        'pais' => ['required' => 'El país es obligatorio.'],
    ];
}
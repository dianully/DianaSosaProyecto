<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultaModel extends Model
{
    protected $table      = 'consultas';
    protected $primaryKey = 'id_consulta';
    protected $returnType = 'array';
    protected $allowedFields = ['id_usuario', 'motivoConsulta', 'comentarioAdicional', 'fecha', 'Respondida', 'Respuesta', 'id_usuario_responde', 'activo'];

    protected $useTimestamps = false;
}
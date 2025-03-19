<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table = 'funcionarios';
    protected $primaryKey = 'funcionario_id';

    protected $fillable = [
        'nombres',
        'apellidos',
        'ci',
        'correo',
        'telefono',
        'estado',
    ];
}

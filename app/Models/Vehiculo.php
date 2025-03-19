<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table = 'vehiculos';
    protected $primaryKey = 'vehiculo_id';

    protected $fillable = [
        'funcionario_id',
        'placa',
        'tipo',
        'estado',
    ];

    public function funcionario() {
        return $this->belongsTo(Funcionario::class, 'funcionario_id', 'funcionario_id');
    }
    
}
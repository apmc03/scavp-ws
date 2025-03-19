<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acceso extends Model
{
    use HasFactory;
    public $timestamps=false;
    protected $table = 'accesos';
    protected $primaryKey = 'acceso_id';

    protected $fillable = [
        'vehiculo_id',
        'visitante',
        'placa',
        'foto_ingreso',
        'foto_salida',
        'fecha_ingreso',
        'fecha_salida'
    ];

    public function vehiculo() {
        return $this->belongsTo(Vehiculo::class, 'funcionario_id', 'funcionario_id');
    }
}

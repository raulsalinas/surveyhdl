<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fecha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.fecha';
    protected $fillable = ['fecha_inicio','fecha_fin','muestreo_id'];
    // protected $appends = ['nombre_encuesta'];

    public function getFechaInicioAttribute()
    {
        $fecha = new Carbon($this->attributes['fecha_inicio']);
        return $fecha->format('d-m-Y');
    }
    public function getFechaFinAttribute()
    {
        $fecha = new Carbon($this->attributes['fecha_fin']);
        return $fecha->format('d-m-Y');
    }

    public function muestreo()
    {
        return $this->hasOne('App\Models\Muestreo', 'id', 'muestreo_id');
    }
}

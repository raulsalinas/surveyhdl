<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Muestreo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.muestreo';
    protected $fillable = ['nombre','encuesta_id'];
    protected $appends = ['nombre_encuesta'];


    public function getNombreEncuestaAttribute()
    {
            $nombreEncuesta= Muestreo::withTrashed()->select('encuesta.nombre')
            ->leftJoin('public.encuesta', 'encuesta.id', '=', 'muestreo.encuesta_id')
            
            ->where(
                [
                    ['encuesta.id', $this->attributes['encuesta_id']],
                    ['encuesta.deleted_at', '=',null]
                ]
            )
            ->first()->nombre??'';
            return $nombreEncuesta;

    }

    public function fecha()
    {
        return $this->hasMany('App\Models\Fecha', 'muestreo_id', 'id');
    }
}

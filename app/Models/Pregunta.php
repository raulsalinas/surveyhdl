<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pregunta extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.pregunta';
    protected $fillable = ['nombre','respuesta_unica'];



    public function respuesta()
    {
        return $this->hasMany('App\Models\Respuesta', 'pregunta_id', 'id');
    }
}

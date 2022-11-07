<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Muestra extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'public.muestra';
    protected $fillable = ['nombre','fecha_id','personal_id'];

    public function fecha()
    {
        return $this->hasOne('App\Models\Fecha', 'id', 'fecha_id');
    }
    public function personal()
    {
        return $this->hasOne('App\Models\Personal', 'id', 'personal_id');
    }
}

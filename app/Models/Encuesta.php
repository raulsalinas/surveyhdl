<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Encuesta extends Model
{
   

    use HasFactory, SoftDeletes;

    protected $table = 'public.encuesta';
    protected $primaryKey = 'id';
    protected $fillable = ['nombre'];
    // public $incrementing = false;
    // protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}

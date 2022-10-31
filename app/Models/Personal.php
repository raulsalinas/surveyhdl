<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'public.personal';
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}

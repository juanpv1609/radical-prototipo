<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificaciones extends Model
{
    protected $table = 'certificaciones';
    protected $fillable = ['solucion','estado','is_deleted'];
    public $timestamps = false;
    protected $guarded = [];
    use HasFactory;
}

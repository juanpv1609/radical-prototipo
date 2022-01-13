<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Marca extends Model
{   protected $table = 'marcas';
    protected $fillable = [
                            'nombre','descripcion','estado','is_deleted'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;




}

<?php

namespace App\Models;




use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modalidad extends Model
{   protected $table = 'modalidades';
    protected $fillable = [
                            'nombre','descripcion','horas','dias','estado','is_deleted'];
    //public $timestamps = false;
    protected $guarded = [];
    use HasFactory;




}

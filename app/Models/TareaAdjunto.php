<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tareas;

class TareaAdjunto extends Model
{
    protected $table = 'tareas_adjuntos';
    protected $fillable = ['tarea_id', 'version', 'adjunto', 'observacion'];

    protected $guarded = [];
    use HasFactory;

    public function tarea()
    {
        return $this->belongsTo(Tareas::class, 'tarea_id', 'id');
    }
}

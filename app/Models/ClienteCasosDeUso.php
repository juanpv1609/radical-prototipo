<?php

namespace App\Models;

use App\Models\Cliente;
use App\Models\CasosDeUso;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClienteCasosDeUso extends Model
{
    use HasFactory;
    protected $table = 'cliente_casos_de_uso';
    protected $fillable = ['cliente_id',
                            'caso_de_uso_id',
                            'resultado_esperado',
                            'escenario',
                            'estado'];
    public $timestamps = false;
    protected $guarded = [];
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }
    public function caso_uso()
    {
        return $this->belongsTo(CasosDeUso::class, 'caso_de_uso_id', 'id');
    }
}

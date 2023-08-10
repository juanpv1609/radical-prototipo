<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contratos;
use App\Models\Destinatario;

class ContratoDestinatario extends Model
{
    protected $table = 'contrato_destinatario';
    protected $fillable = [
                            'contrato_id','destinatario_id','estado'
                            ,'is_deleted'];
    protected $guarded = [];

    use HasFactory;

    public function contratos()
    {
        return $this->belongsToMany(Contratos::class, 'contrato_id','id');
    }

    public function destinatarios()
    {
        return $this->belongsToMany(Destinatario::class, 'destinatario_id','id');
    }
}

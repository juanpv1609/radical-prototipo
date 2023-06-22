<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contrato;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Destinatario extends Model
{
	protected $table = 'destinatarios';
	protected $fillable = [
		'name',
		'email',
		'contrato_id',
		'is_deleted',
	];

	public $timestamps = false;
	protected $guard = [];

	use HasFactory;

	public function contrato()
	{
		return $this->belongsTo(Contrato::class, 'contrato_id', 'id');
	}
}

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
		'is_deleted',
	];

	public $timestamps = false;
	protected $guard = [];

	use HasFactory;


}

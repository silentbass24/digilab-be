<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Corsi
 * 
 * @property string $id
 * @property string $titolo
 * @property string $descrizione
 * @property Carbon $data inizio
 * @property Carbon $data fine
 * @property float $costo
 *
 * @package App\Models
 */
class Corsi extends Model
{
	protected $table = 'corsi';
	protected $primaryKey = 'id(16';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'data inizio' => 'datetime',
		'data fine' => 'datetime',
		'costo' => 'float'
	];

	protected $fillable = [
		'id',
		'titolo',
		'descrizione',
		'data inizio',
		'data fine',
		'costo'
	];
}

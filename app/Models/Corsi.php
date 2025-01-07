<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
    use HasFactory;
	protected $table = 'corsi';
	protected $primaryKey = 'id(16';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'data_inizio' => 'date',
		'data_fine' => 'date',
		'costo' => 'float'
	];

	protected $fillable = [
		'id',
		'titolo',
		'descrizione',
		'data_inizio',
		'data_fine',
		'costo'
	];
}

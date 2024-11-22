<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class IscrizioniCorsi
 *
 * @property string $id
 * @property string $id_corso
 * @property string $id_iscritto
 * @property string $data_iscrizione
 * @property bool $pagato
 *
 * @package App\Models
 */
class IscrizioneCorsi extends Model
{
	protected $table = 'iscrizione_corsi';
	protected $primaryKey = 'id(16';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'pagato' => 'bool'
	];

	protected $fillable = [
		'id',
		'id_corso',
		'id_iscritto',
		'data_iscrizione',
		'pagato'
	];
}

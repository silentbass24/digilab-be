<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Associati
 *
 * @property string $id
 * @property string $nome
 * @property string $cognome
 * @property string $codice_fiscale
 * @property string $nome_genitore
 * @property string $cognome_genitore
 * @property string $telefono
 * @property string $email
 * @property string $indirizzo
 * @property string $citta
 * @property string $provincia
 * @property string $cap
 * @property Carbon $data_di_nascita
 * @property bool $iscritto
 * @property Carbon $data_iscrizione
 * @property Carbon $data_scadenza
 *
 * @package App\Models
 */
class Associati extends Model
{
    use HasFactory;

	protected $table = 'associati';
	protected $primaryKey = 'id(16)';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'data_di_nascita' => 'datetime',
		'iscritto' => 'bool',
		'data_iscrizione' => 'datetime',
		'data_scadenza' => 'datetime'
	];

	protected $fillable = [
		'id',
		'nome',
		'cognome',
		'codice_fiscale',
		'nome_genitore',
		'cognome_genitore',
		'telefono',
		'email',
		'indirizzo',
		'citta',
		'provincia',
		'cap',
		'data_nascita',
		'iscritto',
		'data_iscrizione',
		'data_scadenza'
	];
}

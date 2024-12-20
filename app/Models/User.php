<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * 
 * @property string $id
 * @property string $username
 * @property string $password
 * @property bool $active
 *
 * @package App\Models
 */
class User extends Model
{
	protected $table = 'user';
	protected $primaryKey = 'id(16';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'active' => 'bool'
	];

	protected $hidden = [
		'password'
	];

	protected $fillable = [
		'id',
		'username',
		'password',
		'active'
	];
}

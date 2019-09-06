<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'complaint', 'reason', 'investigator', 'start_date', 'end_date', 'status'
	];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'author', 'description', 'suspect'
	];
	
	/**
	 * Get the complaint author.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author()
	{
		return $this->belongsTo(User::class, 'author');
	}
}

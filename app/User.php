<?php
	
	namespace App;
	
	use Illuminate\Notifications\Notifiable;
	use Illuminate\Contracts\Auth\MustVerifyEmail;
	use Illuminate\Foundation\Auth\User as Authenticatable;
	
	class User extends Authenticatable
	{
		use Notifiable;
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'first_name', 'last_name', 'date_of_birth', 'birthplace', 'gender', 'phone', 'password', 'type', 'active', 'unity'
		];
		
		/**
		 * The attributes that should be hidden for arrays.
		 *
		 * @var array
		 */
		protected $hidden = [
			'password'
		];
		
		/**
		 * The attributes that should be cast to native types.
		 *
		 * @var array
		 */
		protected $casts = [
			'active' => 'boolean',
		];
		
		/**
		 * Get the user unity.
		 *
		 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
		 */
		public function unity()
		{
			return $this->belongsTo(Unity::class, 'unity');
		}
	}

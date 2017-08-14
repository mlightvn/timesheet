<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
	protected $fillable = [
		'id',
		'name',
	];
    protected $table = 'session';
}

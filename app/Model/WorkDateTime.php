<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class WorkDateTime extends Model
{
	protected $fillable = [
		'date',
		'organization_id',
		'user_id',
		'time_in',
		'time_out',
		'work_hour',
		'description',
	];

	protected $table = 'work_datetime';

	protected $primaryKey = ['date', 'organization_id', 'user_id'];
	public $incrementing = false;

	// protected function setKeysForSaveQuery(Builder $query)
	// {
	// 	$keys = $this->getKeyName();
	// 	if(!is_array($keys)){
	// 		return parent::setKeysForSaveQuery($query);
	// 	}

	// 	foreach($keys as $keyName){
	// 		$query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
	// 	}

	// 	return $query;
	// }

	// *
	//  * Get the primary key value for a save query.
	//  *
	//  * @param mixed $keyName
	//  * @return mixed
	 
	// protected function getKeyForSaveQuery($keyName = null)
	// {
	// 	if(is_null($keyName)){
	// 		$keyName = $this->getKeyName();
	// 	}

	// 	if (isset($this->original[$keyName])) {
	// 		return $this->original[$keyName];
	// 	}

	// 	return $this->getAttribute($keyName);
	// }

}

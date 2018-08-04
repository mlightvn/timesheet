<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	// https://laravel.com/docs/5.6/eloquent
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $organization_id = null;
	protected $is_deleted = null;

	protected $search_columns = [];

	public function __construct(){
		$this->init();
	}

	protected function init()
	{
	}

	public function getList($keyword='')
	{
		$model = $this;

		if(isset($this->organization_id) && !empty($this->organization_id)){
			$model = $model->where($this->table . '.organization_id', $this->organization_id);
		}

		if(!empty($keyword)){
			$whereArr = array();
			foreach ($search_columns as $key => $column_name) {
				$whereArr[] = "(" . $column_name . " LIKE '%" . $keyword . "%') ";
			}
			$where = "(" . implode(" OR ", $whereArr) . ")";
			$model = $model->whereRaw($where);
		}

		if(isset($this->is_deleted) && !empty($this->is_deleted)){
			$model = $model->orderBy($this->is_deleted);

			$model = $model->select([
					"*",

					\DB::raw("CASE " . $this->is_deleted . " WHEN 1 THEN 'w3-gray' ELSE '' END AS DELETED_CSS_CLASS"),
					\DB::raw("CASE " . $this->is_deleted . " WHEN 0 THEN 1 ELSE 0 END AS DELETE_FLAG_ACTION"),
					\DB::raw("CASE " . $this->is_deleted . " WHEN 1 THEN 'fa fa-recycle' ELSE 'fa fa-trash' END AS DELETED_RECOVER_ICON"),
					\DB::raw("CASE " . $this->is_deleted . " WHEN 1 THEN 'w3-green' ELSE 'w3-red' END AS DELETED_RECOVER_COLOR"),
				]);
		}

		$list = $model->get();
		return $list;
	}

}

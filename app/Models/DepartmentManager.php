<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartmentManager extends Model
{
	use \Venturecraft\Revisionable\RevisionableTrait;

	protected $revisionEnabled = true;
	protected $revisionCreationsEnabled = true;
	protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
	protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old
	protected $table = 'department_manager';

	protected function department()
	{
		return $this->belongsTo('App\Models\Department', 'department_id', 'id');
	}

	protected function manager()
	{
		return $this->belongsTo('App\Models\Admin', 'manager_id', 'id');
	}
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatabaseBackup extends Model
{
	use \Venturecraft\Revisionable\RevisionableTrait;

	protected $revisionEnabled = true;
	protected $revisionCreationsEnabled = true;
	protected $revisionCleanup = true; //Remove old revisions (works only when used with $historyLimit)
	protected $historyLimit = 500; //Maintain a maximum of 500 changes at any point of time, while cleaning up old

	protected $table = "database_backups";

	protected $guarded = ["id"];
}

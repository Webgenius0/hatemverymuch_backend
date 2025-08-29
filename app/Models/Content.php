<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
	protected $fillable = [
		'tier_id',
		'title',
		'description',
		'schedule',
		'file',
		'creator',
	];

	public function PivotRelationWith_tags()
	{
		return $this->belongsToMany(Tag::class, 'content_tag_pivots');
	}

	public function contentsRelationTo_users()
	{
		return $this->belongsTo(User::class, 'creator');
	}
}

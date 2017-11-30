<?php
namespace App\QueryScopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Tweets implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		$builder->orderByDesc('created_at');
	}
}
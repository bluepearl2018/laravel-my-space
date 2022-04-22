<?php

namespace Eutranet\MySpace\Repository\Eloquent;

use Eutranet\Setup\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class MySpaceUserRepository extends BaseRepository
{
	public function __construct(Model $model)
	{
		parent::__construct($model);
	}
}
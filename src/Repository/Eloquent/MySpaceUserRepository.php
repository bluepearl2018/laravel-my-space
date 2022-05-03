<?php

namespace Eutranet\MySpace\Repository\Eloquent;

use Eutranet\Setup\Repository\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use JetBrains\PhpStorm\Pure;

class MySpaceUserRepository extends BaseRepository
{
    #[Pure]
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }
}

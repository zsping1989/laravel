<?php

namespace App\Models;

use App\BaseModel;
use App\Exceptions\MarginTree\TreeModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends BaseModel
{
    use SoftDeletes,TreeModel;
}

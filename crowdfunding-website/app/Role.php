<?php

namespace App;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use UseUuid;

    protected $guarded = [];
}

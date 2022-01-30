<?php

namespace App;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use UseUuid;

    protected $guarded = [];
}

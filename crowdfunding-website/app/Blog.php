<?php

namespace App;

use App\Traits\UseUuid;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use UseUuid;

    protected $guarded = [];
}

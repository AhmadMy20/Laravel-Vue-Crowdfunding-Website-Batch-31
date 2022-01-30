<?php

namespace App;

use App\User;
use App\Traits\UseUuid;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use UseUuid;

    protected $guarded = [];

    public function user()
    {
        return $this->hasMany(User::class);
    }
}

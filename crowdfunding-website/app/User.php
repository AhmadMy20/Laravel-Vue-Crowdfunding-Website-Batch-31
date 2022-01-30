<?php

namespace App;

use App\Otp;
use App\Role;
use App\Traits\UseUuid;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, UseUuid;

   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'username', 'email', 'password', 'role_id'
    // ];
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function getRoleId()
    {
        $role = Role::where('name', 'user')->first();
        return $role->id;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->role_id = $model->getRoleId();
        }); 
        
        static::creating(function ($model) {
            $model->password = bcrypt('1234');
        }); 
        
        static::created(function ($model) {
            $model->generateCodeOtp();
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        if($this->role_id === $this->getRoleId()){
            return false;
        }

        return true;
    }

    public function generateCodeOtp()
    {
        do {
            $random = mt_rand(100000, 999999);
            $check = Otp::where('otp', $random)->first();
        } while ($check);

        $current = Carbon::now();

        $otpcode = Otp::updateOrCreate(
            ['user_id' => $this->id],
            ['otp' => $random, 
            'valid_until' => $current->addMinutes(5)
            ]);
    }

    public function otpCode()
    {
        return $this->hasOne('App\Otp', 'user_id', 'id');
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
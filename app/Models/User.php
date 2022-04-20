<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Filterable, Shamsi;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_retailer',
        'mobile',
        'emergency_mobile',
        'telephone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cart()
    {
        return $this->belongsToMany(Variation::class, 'carts', 'user_id')
            ->withPivot('quantity')->with(['product' => function ($q) {
                return $q->without('variations');
            }]);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function retailer()
    {
        return $this->hasOne(Retailer::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', "%$value%")->orWhere('email', 'like', "%$value%");
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function getAreaCodeAttribute()
    {
        return substr($this->telephone, 0, strlen($this->telephone)  - 8);
    }

    public function getTelephonePartAttribute()
    {
        return substr($this->telephone, -8, 8);
    }
}

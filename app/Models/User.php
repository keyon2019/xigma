<?php

namespace App\Models;

use App\Traits\Filterable;
use App\Traits\Shamsi;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Morilog\Jalali\Jalalian;

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
        'telephone',
        'is_active',
        'total_points',
        'birthday',
        'roles',
        'ssn'
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
        'roles' => 'array'
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

    public function retailers()
    {
        return $this->hasMany(Retailer::class);
    }

    public function returnRequests()
    {
        return $this->hasMany(ReturnRequest::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', "%$value%")
            ->orWhere('email', 'like', "%$value%")
            ->orWhere('mobile', $value);
    }

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function coupons()
    {
        return $this->hasMany(Coupon::class);
    }

    public function getAreaCodeAttribute()
    {
        return substr($this->telephone, 0, strlen($this->telephone) - 8);
    }

    public function getTelephonePartAttribute()
    {
        return substr($this->telephone, -8, 8);
    }

//    public function getBirthdayAttribute($value)
//    {
//        if ($value)
//            return Jalalian::forge($value)->format('Y/m/d');
//        return null;
//    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class);
    }

    public function hasRole($role)
    {
        return in_array($role, $this->roles ?? []);
    }

    protected function castAttribute($key, $value)
    {
        if ($this->getCastType($key) == 'array' && is_null($value)) {
            return [];
        }

        return parent::castAttribute($key, $value);
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function scopeQueryHasRole($query, $role)
    {
        return $query->where('roles', 'like', "%$role%");
    }

    public function scopeAdminAndRoles($query, ...$roles)
    {
        $query->whereIsAdmin(true);
        if (!!$roles) {
            collect($roles)->each(function ($role) use ($query) {
                return $query->orWhere('roles', 'like', "%$role%");
            });
        }
    }
}

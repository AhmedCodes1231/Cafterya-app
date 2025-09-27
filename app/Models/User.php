<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
    // علاقة المستخدم مع الفواتير

{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['username',
    'name',
    'email',
    'status',
    'password'];



    public function invoices()
    {
        return $this->hasMany(SalesInvoice::class);
    }
// App\Models\User.php
public function roles()
{
    return $this->belongsToMany(Role::class, 'user_roles');
}


 // دالة مساعدة للتحقق إذا كان لديه دور معين
    public function hasRole($roleName)
    {
        return $this->roles->pluck('name')->contains($roleName);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function salesInvoices()
    {
        return $this->hasMany(SalesInvoice::class, 'user_id');
    }

    // علاقة المستخدم مع الأدوار
}

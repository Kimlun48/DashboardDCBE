<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class User extends Model
{
    use HasFactory, Notifiable, HasApiTokens, HasRoles;
    
    protected $guard_name = 'api';

    protected $fillable = [
        'name',
        'email',
        'password',
        'id_branch',
        'name_branch',
        'is_online'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr['name'] => true];
        });
    }
}

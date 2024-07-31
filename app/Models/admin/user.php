<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class user extends Model
{
    use HasFactory,Notifiable, HasApiTokens, HasRoles;

    protected $guard_name ='api';

    protected $fillable = [
        'name',
        'email',
        'password',
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

    /**
     * getPermissionArray
     *
     * @return void
     */
    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr['name'] => true];
        });
   
    }
   
}

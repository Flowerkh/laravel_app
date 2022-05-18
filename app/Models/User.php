<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'admin_user';
    protected $primaryKey = 'u_idx'; #테이블 기준 pk 정해줘야함

    protected $fillable = [
        'email',
        'password',
        'u_name',
        'team',
        'c_date',
        'u_date',
        'use_yn',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        //'remember_token',
    ];
}

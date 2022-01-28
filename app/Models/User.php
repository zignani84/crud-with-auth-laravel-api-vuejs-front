<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'phone',
        'avatar',
        'password',
    ];

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
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }

    public static function auth_rules($id=0, $merge=[]) {
        return array_merge(
            [
                'name'       => 'required|string|between:2,100',
                'email'       => 'required|string|email|max:100|unique:users' . ($id ? ",$id" : ''),
                'password'   => 'required|string|confirmed|min:6',
            ], 
            $merge);
    }

    public static function login_rules() {
        return
        [
            'email'     => 'required|email',
            'password' => 'required|string|min:6',
        ];
    }

    public static function users_rules($id=0, $merge=[]) {
        return array_merge(
            [
                'name'       => 'required|string|between:2,100',
                'email'       => 'required|string|email|max:100|unique:users' . ($id ? ",$id" : ''),
                'phone'      => 'string|between:13,18',
                'password'   => 'required|string|confirmed|min:6',
            ], 
            $merge);
    }

    public static function users_edit_rules() {
        return
        [
            'name'       => 'required|string|between:2,100',
            'email'       => 'required|string|email|max:100',
        ];
    }
}

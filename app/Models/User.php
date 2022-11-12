<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Exceptions\NotPermissions;
use App\Exceptions\SomethingWentWrong;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function institution()
    {
        return $this->hasOne(Institution::class, 'id', 'institution_id');
    }

    //Usuarios Activos
    public function scopeActivos($query, $activo)
    {
        if (!empty($activo)) {
            return  $query->where('active', true);
        }
    }

    //PERMISSIONS
    public function hasModulo($modulo)
    {
        foreach (auth()->user()->role->modulos as $item) {
            if ($item->modulo->nombre == $modulo) {
                return true;
            }
        }
        throw new NotPermissions;
    }

    public function hasPermiso($permiso)
    {
        foreach (auth()->user()->role->permisos as $item) {
            if ($item->permiso->nombre == $permiso) {
                return true;
            }
        }
        throw new NotPermissions;
    }

    public function institucional()
    {
        foreach (auth()->user()->role->permisos as $item) {
            if ($item->permiso->nombre == "institucion") {
                return true;
            }
        }
        return false;
    }
}
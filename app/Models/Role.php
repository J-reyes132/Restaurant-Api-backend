<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    public function permisos(){
        // return $this->hasManyThrough(RolePermiso::class, Permiso::class);
        return $this->hasMany(RolePermiso::class);
    }

    public function modulos(){
        // return $this->hasManyThrough(RoleModulo::class, Modulo::class);
        return $this->hasMany(RoleModulo::class);
    }

    public function usuarios()
    {
        return $this->hasMany(User::class);
    }
}
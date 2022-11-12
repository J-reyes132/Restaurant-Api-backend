<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModulo extends Model
{
    use HasFactory;

    public function role()
    {
        return $this->hasOne(Role::class, 'id', 'role_id');
    }

    public function modulo()
    {
        return $this->hasOne(Modulo::class, 'id', 'modulo_id');
    }
}
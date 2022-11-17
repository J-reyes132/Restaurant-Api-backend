<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    public function ScopeName($query, $name){
        if(!empty($name)){
        return $query->where('first_name', 'LIKE', '%'.$name.'%'); 
    }
}

    public function ScopeLastName($query,$last_name){
        if(!empty($last_name)){
            return $query->where('last_name','LIKE', '%'.$last_name.'%');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function ScopeName($query, $name){
        if(! empty($name)){
            return $query->where('first_name', 'LIKE', '%'.$name.'%')
                         ->orWhere('last_name', 'LIKE', '%'.$name.'%');
        }
    }
}

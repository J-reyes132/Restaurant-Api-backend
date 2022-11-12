<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public function ScopeCapacity($query, $capacity){
        if(!empty($capacity)){
            return $query->where('capacity', '=', $capacity);
        }
    }
}

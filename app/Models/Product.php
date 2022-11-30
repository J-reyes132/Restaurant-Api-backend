<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function ScopeName($query, $name){
        if(!empty($name)){
            return $query->where('name', 'LIKE', '%'.$name.'%');
        }
    }

    public function inventory(){
        return $this->hasOne(Inventory::class, 'product_id', 'id');
    }
}

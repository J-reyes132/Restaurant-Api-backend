<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function table(){
        return $this->hasOne(Table::class, 'id');
    }

    public function customer(){
        return $this->hasOne(Customer::class, 'id');
    }

    public function product(){
        return $this->hasOne(Product::class, 'id');
    }

    public function menu(){
        return $this->hasOne(Menu::class, 'id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['name', 'address', 'phone'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_branch')
            ->withPivot('stock')
            ->withTimestamps();
    }
}

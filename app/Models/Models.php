<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    protected $fillable = ['car_id', 'model'];
    
    public function car()
    {
        return $this->belongsTo(Cars::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }

}

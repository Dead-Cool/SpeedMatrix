<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = ['car_id', 'model_id', 'title', 'price', 'description', 'photo'];

    public function car()
    {
        return $this->belongsTo(Cars::class);
    }

    public function model()
    {
        return $this->belongsTo(Models::class);
    }
}

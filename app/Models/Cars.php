<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;
 
    protected $fillable = ['name'];
    
    public function models()
    {
        return $this->hasMany(Model::class);
    }

    public function product()
    {
        return $this->hasMany(Product::class);
    }
}

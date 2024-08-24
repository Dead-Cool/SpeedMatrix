<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    use HasFactory;

    public function car()
    {
        return $this->belongsTo(Cars::class);
    }

    protected $fillable = ['car_id', 'model'];
}

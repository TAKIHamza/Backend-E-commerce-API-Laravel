<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['title','image','catigory', 'description', 'price'];

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}


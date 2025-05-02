<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    protected $fillable = ['user_id', 'product_id', 'quantity','is_validate','date_commande','adresse','telephone','received'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

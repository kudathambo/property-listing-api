<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
      'broker_id', 'address', 'listing_type', 'city', 'description'
    ];

    public function characteristic(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(PropertyCharacteristic::class);
    }
}

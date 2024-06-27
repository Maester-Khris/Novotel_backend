<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['uuid','full_name','birth_date','telephone','nationality_country_id',
    'living_country_id','address_location_id','nic_card_id','nic_card_delivery','created_at'];

    public function visits(){
        return $this->hasMany(Visit::class);
    }

    
}

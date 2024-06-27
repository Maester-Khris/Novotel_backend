<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $fillable = ['uuid','comp_name','comp_telephone','comp_location_id',
    'comp_mail_address','comp_web_site','comp_standing_stars','created_at'];

    /**
     * Notes:
     * client dont reaaly belong to a company since the are searchable throug the entire app
     * although to get the list of client that made a visit in a company go by visit and select all unique clientid
    */
    

    public function resources(){
        return $this->hasMany(Resource::class);
    }
    public function commodities(){
        return $this->hasMany(Commodity::class);
    }
    public function users(){                    
        return $this->hasMany(User::class);
    }
    public function visits(){
        return $this->hasMany(Visit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Visit extends Model
{
    use HasFactory;
    protected $appends = ['company_uuid','client_uuid'];
    protected $fillable = ['uuid','visit_start_date','visit_end_date','client_coming_from','client_going_to','created_at'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function getCompanyUuidAttribute(){
        return $this->company->uuid;
    }
    public function getClientUuidAttribute(){
        return $this->client->uuid;
    }

    // public function getLocationFromAttribute()
    // {
    //     $location = DB::table('locations')->where('id',$this->client_coming_from)->first();
    //     $details = json_decode($location->place, true);
    //     return $details;
    // }
    // public function getLocationToAttribute()
    // {
    //     $location = DB::table('locations')->where('id',$this->client_going_to)->first();
    //     $details = json_decode($location->place, true);
    //     return $details;
    // }
}

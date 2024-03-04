<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $appends = ['company_uuid'];
    protected $fillable=['uuid','resource_name','resource_availability','is_room','is_appartment','is_bed','created_at'];

    public function visit(){
        return $this->hasOne(Visit::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    public function getCompanyUuidAttribute(){
        return $this->company->uuid;
    }
}

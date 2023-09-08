<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $fillable=['uuid','resource_name','resource_availability','is_room','is_appartment','is_bed','created_at'];

    public function visit(){
        return $this->hasOne(Visit::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;
    protected $fillable = ['uuid','visit_start_date','visit_end_date','client_coming_from','client_going_to','created_at'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}

<?php

namespace App\Models;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'doctors_id');
    }
}

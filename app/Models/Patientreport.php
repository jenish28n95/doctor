<?php

namespace App\Models;

use App\Models\Rtype;
use App\Models\Patient;
use App\Models\Childrtype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patientreport extends Model
{
    use HasFactory;

    protected $uploads = '/patientsdocs/';

    protected $guarded = [];

    public function getFileAttribute($photo)
    {

        return $this->uploads . $photo;
    }

    public function patients()
    {
        return $this->belongsTo(Patient::class);
    }

    public function reports()
    {
        return $this->belongsTo(Rtype::class);
    }

    public function childreports()
    {
        return $this->belongsTo(Childrtype::class);
    }
}

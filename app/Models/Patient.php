<?php

namespace App\Models;

use App\Models\Admin;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function doctors()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function admins()
    {
        return $this->belongsTo(Admin::class);
    }
}

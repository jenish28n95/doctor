<?php

namespace App\Models;

use App\Models\Rtype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Childrtype extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function rtypes()
    {
        return $this->belongsTo(Rtype::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function client()
    {
        return $this->hasOne('App\Models\Client', 'id', 'client_id');
    }
}
